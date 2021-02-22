<?php


namespace app\admin\controller;


use think\facade\View;

use app\admin\business\Brand as BrandB;

class Brand extends AdminBase
{
    /**
     * 品牌添加主页
     * @return string
     */
    public function index(){

        return View::fetch();
    }

    /**
     * 品牌添加入库
     * @return \think\response\Json
     */
    public function create(){

        if (!$this->request->isPost()){

            return show(config('status.error'),'not error',[],100);
        }

        $brand_name =   $this->request->param('brand_name','','trim');

        $brand_url  =   $this->request->param('brand_url','','trim');

        $brand_img  =   $this->request->param('brand_img','','trim');

        $brand_data = [
            'brand_name'    =>  $brand_name,
            'brand_url'     =>  $brand_url,
            'brand_img'     =>  $brand_img
        ];

        $validate = new \app\admin\validate\BrandVali();

        if (!$validate->check($brand_data)){

            return fail($validate->getError(),config('status.error'));
        }

        try {
            $brandB = new BrandB();

            $res    =   $brandB->brandCreate($brand_data);

        }catch (\Exception $e){

            return fail($e->getMessage(),config('status.error'));
        }

        if ($res){
            return success([],config('status.success'),'添加成功');
        }

        return fail('添加失败',config('status.error'));

    }

    //图片上传的方法
    public function uploadBrandImg(){

        $file = request()->file('file');

        $savename = \think\facade\Filesystem::putFile( 'upload_brand_img', $file);

        if (!empty($savename)){
            $data = [
              'path' => '/storage/'.str_replace('\\','/',$savename)
            ];
            return success($data);
        }else{
            return fail('上传失败');
        }

    }

}