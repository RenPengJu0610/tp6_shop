<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/5/22/22:45
 */

namespace app\api\controller;

use app\common\business\CateGory as CategoryBus;
use app\common\lib\Show;
use think\Exception;

class CateGory extends ApiBase
{
    public function index(){
        $cateGoryBusObj = new CategoryBus();

        $categorys = $cateGoryBusObj->getNormalAllCateGorys();

        $result = \app\common\lib\Arr::getTree($categorys);

        $result = \app\common\lib\Arr::sliceTreeArr($result);

        return show(config('status.success'),'OK',$result);
    }

    public function search(){

        $category_id = $this->request->get('cid',0,'intval');
        if (empty($category_id)){
            throw new Exception('没有相关分类，请重试');
        }
        try {
            $result = (new CategoryBus())-> getNormalDataByCategoryId($category_id);

        }catch (\Exception $e){
            return Show::fail($e->getMessage());
        }
        return Show::success($result);
    }
}