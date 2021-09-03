<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/8/26/19:03
 */

namespace app\api\controller\mall;


use app\api\controller\ApiBase;
use app\common\business\Goods as GoodsBus;
use app\common\lib\Show;

class Detail extends ApiBase
{
    public function index(){
        $id = input('param.id',0,'intval');
        $result = (new GoodsBus())->getGoodsDetailBySkuId($id);

        if (!$result){
            return Show::fail();
        }

        return Show::success($result);
    }
}