<?php


namespace app\admin\controller;

/**
 * 退出登录
 * Class LoginOut
 * @package app\admin\controller
 */
class LoginOut
{
    public function index(){
        //清楚session
        session(config('session.admin_session'),null);
        //执行跳转
        return redirect('/admin/login/index');
    }
}