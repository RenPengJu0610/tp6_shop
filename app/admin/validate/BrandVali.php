<?php


namespace app\admin\validate;


use think\Validate;

class BrandVali extends Validate
{

    protected $rule = [
        'brand_name'    =>  'require',
        'brand_url'     =>  'require',
    ];

    protected $message = [
        'brand_name'    =>  '品牌名称必填',
        'brand_url'     =>  '品牌网址必填',
    ];
}