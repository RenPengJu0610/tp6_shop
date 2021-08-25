<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/4/15:54
 */

namespace app\admin\validate;


use think\Validate;

class Specs extends Validate
{
    protected $rule = [
        'specs_id' => 'require|number',
        'name'  =>  'require'

    ];

    protected $message = [
        'specs_id.require'=> 'specs_id必传',
        'specs_id.number'=>'specs_id必须为数字',
        'name'  =>  '规格名必传'
    ];

    protected $scene = [
        'add'   =>  ['specs_id','name']
    ];
}