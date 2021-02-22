<?php


namespace app\admin\controller;

/**
 * 引用验证码门面模式
 */
use think\captcha\facade\Captcha;

/**
 * 自定义验证码机制
 * Class Verify
 * @package app\admin\controller
 */
class Verify extends Captcha
{
    public function index(){
        return Captcha::create();
    }
}