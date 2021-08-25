<?php


namespace app\admin\controller;

use app\common\model\mysql\AdminUser as AdminUserModel;
use think\Exception;
use think\facade\View;
use app\admin\business\AdminLogin;
class Login extends AdminBase
{

    public function initialize()
    {
        if($this->isLogin()){
            return $this->redirect(url('index/index'));
        }
    }

    /**
     * 后台登录首页
     * @return string
     */
    public function index(){

        return View::fetch();
    }

    public function str(){
        var_dump(session(config('session.admin_session')));
}
    /**
     * 检测用户传递的参数
     */
    public function check(){

        if(!$this->request->isPost()){

           return show(config('status.request_not_error'),'请求方式不正确',[],300);
        }

        $username = $this->request->param('username','','trim');

        $password = $this->request->param('password','','trim');

        $captcha = $this->request->param('captcha','','trim');

        $data = [
          'username'    =>  $username,
          'password'    =>  $password,
          'captcha'     =>  $captcha
        ];
//        if (!captcha_check($captcha)){
//            return  show(config('status.error'),'验证码不正确');
//        }

        $validate = new \app\admin\validate\AdminUser();

        if (!$validate->check($data)){

            return show(config('status.error'),$validate->getError());
        }

        try {
            $adminLogin = new AdminLogin();

            $result = $adminLogin->login($data);

        }catch (\Exception $e){

            return show(config('status.error'),$e->getMessage());

        }

        if ($result){

            return show(config('status.success'),'登录成功',[],200);
        }

        return show(config('status.error'),'登录失败',[],300);

    }
}