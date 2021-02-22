<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2020/12/18/23:46
 */

namespace app\api\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username'      =>  'require',
        'phone_number'  =>  'require|number|length:11',
        'code'          =>  'require|number|min:4',
        'type'          =>  ['require','in'=>'1,2'],
        'sex'           =>  ['require','in'=>'1,2,3']
    ];

    protected $message = [
        'username'  =>  '用户名必须',
        'phone_number'  =>  '手机号必须',
        'phone_number.number'   =>  '手机号必须由数字组成',
        'phone_number.length'       =>'手机号格式不正确',
        'code.require'  =>  '短信验证码必填',
        'code.number'   =>  '验证码必须为数字',
        'code.min'      =>  '验证码长度不得低于4位',
        'type.require'  =>  '类型错误',
        'type.in'       =>  '类型值错误',
        'sex.in'        =>  '类型值错误'
    ];

    protected $scene = [
        'send_code' =>  ['phone_number'],
        'login'     =>  ['phone_number','type','code'],
        'updateusername'    =>  ['username','sex']
    ];
}