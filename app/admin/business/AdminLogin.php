<?php


namespace app\admin\business;


use app\BaseController;
use app\common\model\mysql\AdminUser as AdminUserModel;
use think\Exception;

class AdminLogin
{
    public $adminModel = null;
    public function __construct()
    {
        $this->adminModel = new AdminUserModel();
    }

    public function login($data){

         $userData = $this->getAdminUserByUserName($data['username']);

         if (empty($userData)){
             throw new Exception('用户不存在');
             //return show(config('status.error'),'用户不存在',[],300);
         }

        if (md5($data['password']) != $userData['password']){
            throw new Exception('账号密码不存在');

            //return show(config('status.error'),'账号密码不正确',[],300);

        }
        $updateData = [
            'update_time' => time(),
            'last_login_time' => time(),
            'last_login_ip' => request()->ip()
        ];

        $rel = $this->adminModel->updateById($userData['admin_id'],$updateData);

        if (empty($rel)){

            throw new Exception('登录失败');

        }
        session(config('session.admin_session'),$userData);

        return  true;
    }


    /**
     * 根据用户名获取用户信息
     * @param $username
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAdminUserByUserName($username){
        $adminModel = $this->adminModel;

        $userInfo   =   $adminModel->getAdminUserByUserName($username);

        if(empty($userInfo) || $userInfo->status != config('status.mysql.table_normal')){

            return  false;

        }

        $userData = $userInfo->toArray();

        return  $userData;
    }
}