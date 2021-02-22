<?php


namespace app\admin\business;

use \app\common\model\mysql\Brand as BrandModel;
use think\Exception;

class Brand
{
    public $brandModel = null;

    public function __construct()
    {
        $this->brandModel = new BrandModel();
    }

    //品牌添加
    public function brandCreate($data){

        $checkBrandName = $this->getBrandByBrandName($data['brand_name']);

        if (empty($checkBrandName)){

            throw new Exception('品牌名称已存在');
        }

        $brandData = [
            'brand_name'    =>  $data['brand_name'],
            'brand_url'     =>  $data['brand_url'],
            'brand_img'     =>  $data['brand_img'],
            'c_time'        =>  time()
        ];

        $result = $this->brandModel->createBrand($brandData);

        if (empty($result)){

            throw new Exception('品牌添加失败');
        }

        return true;

    }

    public function getBrandByBrandName($brandName){

        $brandModel = $this->brandModel;

        if (empty($brandName)){

            return false;
        }

        if (empty($brandModel->checkBrandNameIfExist($brandName))){

            return  true;
        }

        return false;


    }

}