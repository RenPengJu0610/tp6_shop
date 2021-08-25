<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/6/4/23:32
 */

namespace app\admin\controller;


use think\facade\Log;
use think\facade\View;
use app\common\business\Specs as SpecsBus;
class Specs extends AdminBase
{
    public function add(){

        $param = $this->request->param();
        try {
            validate(\app\admin\validate\Specs::class)->scene('add')->check($param);
            $id = (new SpecsBus())->add($param);
        }catch (\Exception $e){
            Log::error('validata-add-'.$e->getMessage(),[],$e->getMessage());
            return show(config('status.error'),$e->getMessage());
        }

        return  show(config('status.success'),'添加成功',['id'=>$id],200);

    }
    public function dialog(){
        return View::fetch("",
            ['specs' => json_encode(config('specs'))]
        );
    }
    public function getBySpecsId(){
        $specsId = $this->request->param('specs_id',0,'intval');
        if (!$specsId){
            return show(config('status.error'),'没有数据哦');
        }
        $res = (new SpecsBus())->getNormalBySpecsId($specsId);
        return show(config('status.success'),'OK',$res,200);
    }
}