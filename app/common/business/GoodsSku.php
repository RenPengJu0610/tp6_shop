<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/11/20:06
 */

namespace app\common\business;

use app\common\model\mysql\GoodsSku as GoodsSkuModel;
use think\Exception;

class GoodsSku extends BusBase
{
    public $Model = null;

    public function __construct()
    {
        $this->Model = new GoodsSkuModel();
    }

    public function getNormalSkuAndGoods($id){
        return $this->Model->with('goods')->find($id);
    }

    public function getSkusByGoodsId($goods_id = 0){
        if (!$goods_id){
            return [];
        }
        try {
            $result = $this->Model->getSkusByGoodsId($goods_id);
        }catch (\Exception $e){
            return [];
        }
        if (!$result){
            return [];
        }
        return $result -> toArray();
    }
    public function saveAll($data){
        if (!$data['skus']){
            return false;
        }
        foreach ($data['skus'] as $value){
            $insertData[] = [
                'goods_id' => $data['goods_id'],
                'specs_value_ids' => $value['propvalnames']['propvalids'],
                'price' =>  $value['propvalnames']['skuSellPrice'],
                'cost_price' => $value['propvalnames']['skuMarketPrice'],
                'stock' =>  $value['propvalnames']['skuStock'],
                'status'    =>  config('status.mysql.table_normal')
            ];
        }
        try {
            $res = $this->Model->saveAll($insertData);
            return $res->toArray();
        }catch (\Exception $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }
}