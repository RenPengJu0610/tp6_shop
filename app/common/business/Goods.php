<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/11/14:32
 */

namespace app\common\business;

use app\common\model\mysql\Goods as GoodsModel;
use app\common\business\GoodsSku as GoodsSkuBus;
use app\common\model\mysql\Category;
use think\Exception;
use think\facade\Log;

class Goods extends BusBase
{
    public $Model = null;

    public function __construct()
    {
        $this->Model = new GoodsModel();
    }

    public function getLists($data = [], $num = 5)
    {
        $listKey = [];
        if (!empty($data)) {
            $listKey = array_keys($data);
        }
        try {
            $list = $this->Model->getLists($listKey, $data, $num);
            $result = $list->toArray();
        } catch (\Exception $e) {
            $result = \app\common\lib\Arr::getPaginateDefaultData($num);
        }
        return $result;
    }

    public function insterDate($data)
    {
        //开启事务
        $this->Model->startTrans();
        try {
            $goodsId = $this->add($data);
            if (!$goodsId) {
                return $goodsId;
            }
            if ($data['goods_specs_type'] == 1) {
                $goodsSkuData = [
                    'goods_id' => $goodsId
                ];
                return true;
            } elseif ($data['goods_specs_type'] == 2) {
                $GoodsSkuBus = new GoodsSkuBus();
                $data['goods_id'] = $goodsId;
                $res = $GoodsSkuBus->saveAll($data);
                if (!empty($res)) {
                    $stock = array_sum(array_column($res, 'stock'));
                    $goodsUpdateData = [
                        'price' => $res[0]['price'],
                        'cost_price' => $res[0]['cost_price'],
                        'stock' => $stock,
                        'sku_id' => $res[0]['id']
                    ];

                    $goodsRes = $this->Model->updateById($goodsId, $goodsUpdateData);
                    if (!$goodsRes) {
                        throw new Exception('insertData:goods主表更细失败');
                    }
                } else {
                    throw new Exception('sku表新增失败');
                }
            }
            //事务提交
            $this->Model->commit();
            return true;
        } catch (\Exception $e) {
            //事务回滚
            $this->Model->rollback();
            return false;

        }
        return true;
    }

    // 获取商城首页轮播图
    public function getRotationChart()
    {
        try {
            $field = 'id,title,big_image as image';
            $where = ['is_index_recommend' => 1];
            $result = $this->Model->getRotationChart($where, $field);
        } catch (\Exception $e) {
            $result = [];
        }
        return $result->toArray();
    }

    public function cagegoryGoodsRecommend($cateGoryIds)
    {

        $result = [];
        foreach ($cateGoryIds as $k => $cateGoryId) {
            $result[$k]['categorys'] = $this->getByCateGoryIdNromalList($cateGoryId);
        }
        foreach ($cateGoryIds as $key => $cateGoryId) {
            $result[$key]['goods'] = $this->getNormalGoodsFindInSetCategoryId($cateGoryId);
        }
        return $result;
    }

    public function getByCateGoryIdNromalList($cateGoryId)
    {
        try {
            $result = (new Category())->getByCateGoryIdNromalList($cateGoryId);
        } catch (\Exception $e) {
            return [];
        }
        return $result;

    }

    public function getNormalGoodsFindInSetCategoryId($categoryId)
    {
        $field = "sku_id as id,price,title,recommend_image as image";

        try {
            $result = $this->Model->getNormalGoodsFindInSetCategoryId($field, $categoryId);
        } catch (\Exception $e) {
            return [];
        }
        return $result->toArray();

    }

    public function getGoodsDetailBySkuId($skuId)
    {
        $goodsSkyObj = new GoodsSkuBus();

        $goodsSku = $goodsSkyObj->getNormalSkuAndGoods($skuId);

        if (!$goodsSku) {
            return [];
        }
        if (empty($goodsSku['goods'])) {
            return [];
        }
        $goods = $goodsSku['goods'];

        $skus = $goodsSkyObj->getSkusByGoodsId($goods['id']);

        if (!$skus) {
            return [];
        }
        $flagValue = "";

        foreach ($skus as $sv) {
            if ($sv['id'] == $skuId) {
                $flagValue = $sv['specs_value_ids'];
            }
        }

        $gids = array_column($skus, 'id', 'specs_value_ids');
        if ($goods['goods_specs_type'] == 1) {
            return [];
        } else {
            $sku = (new \app\common\business\Specs())->dealGoodsSkus($gids, $flagValue);
        }
        $result = [
            'title' => $goods['title'],
            'price' => $goodsSku['price'],
            'cost_price' => $goodsSku['cost_price'],
            'sales_count' => 0,
            'stock' => $goodsSku['stock'],
            'gids' => $gids,
            'image' => $goods['carousel_image'],
            'sku' => $sku,
            'detail' => [
                'd1' => [
                    "商品编码" => $goodsSku['id'],
                    "上架时间" => $goods['create_time'],
                ],
                'd2' => preg_replace('/(<img.+?src=")(.*?)/', '$1' . request()->domain() . '$2', $goods['description']),
            ]
        ];
        return $result;
    }
}