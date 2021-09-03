<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/11/19:56
 */

namespace app\common\model\mysql;


use think\Model;

class GoodsSku extends Model
{
    protected $table = 'mall_goods_sku';
    protected $autoWriteTimestamp = true;

    public function goods(){
        return $this->hasOne('goods','id','goods_id');
    }

    public function getSkusByGoodsId($goods_id = 0){
        $where = [
           'goods_id' => $goods_id,
           'status' => config('status.mysql.table_normal')
        ];

        return $this->where($where)->select();
    }

}