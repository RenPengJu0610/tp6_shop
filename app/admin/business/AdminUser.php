<?php
//练习。不算数

namespace app\admin\business;


use app\BaseController;

use \app\common\model\mysql\AdminUser as AdminUserModel;

class AdminUser extends BaseController
{
    public function login($data){

            $userInfo = $this->getAdminUserByUserName($data['username']);

            if (empty($userInfo)){

                return  show(config('status.error'),'登录失败',[],404);
            }

            if (md5($data['password']) != $userInfo['password']){

                return  show(config('status.error'),'账号密码不正确',[],404);
            }

            $updateData = [
                'update_time' => time(),
                'last_login_time' => time(),
                'last_login_ip' => request()->ip()
            ];


            $adminModel = new  AdminUserModel();

            $res =  $adminModel->updateById($userInfo['admin_id'],$updateData);

            if (empty($res)){

                return  show(config('status.error'),'登录失败',[],404);
            }

            return true;

    }

    /**
     * 根据用户名获取用户信息
     * @param $username
     * @return array|false|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAdminUserByUserName($username){


    }

}