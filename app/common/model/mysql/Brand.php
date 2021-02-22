<?php


namespace app\common\model\mysql;


use think\Model;

class Brand extends Model
{
    protected $table ="brand";

    protected $pk = 'brand_id';

    //品牌添加
    public function createBrand($data){

        if (empty($data)){

            return false;
        }

        $this->brand_name = $data['brand_name'];

        $this->brand_log  = $data['brand_img'];

        $this->brand_url  = $data['brand_url'];

        $this->c_time     = $data['c_time'];

        $result = $this->save();

        return $result;

    }
    public function checkBrandNameIfExist($brand_name){

        if (empty($brand_name)){

            return false;
        }

        $where = [
            'brand_name'    =>  trim($brand_name)
        ];

        $brandInfo = $this->where($where)->find();

        return $brandInfo;


    }
}