<?php


namespace app\admin\validate;



use think\Validate;

/**
 * 后台用户登录自定义验证规则
 * Class AdminUser
 * @package app\admin\validata
 */
class AdminUser extends Validate
{
    protected  $rule = [
        'username'=>'require',
        'password'=>'require',
        'captcha'=>'require|checkCapcha',
    ];
    protected $message = [
        'username'=>'用户名必填',
        'password'=>'密码必填',
        'captcha'=>'验证码必填'
    ];
    protected function checkCapcha($value, $rule, $data = []) {
        if(!captcha_check($value)) {
            return "您输入的验证码不正确！";
        }
        return true;
    }
}