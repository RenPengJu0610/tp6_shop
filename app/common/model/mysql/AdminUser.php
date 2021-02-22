<?php


namespace app\common\model\mysql;


use think\Model;

class AdminUser extends Model
{
    protected $table ="admin_user";

    protected $pk = 'admin_id';

    /**
     * 根据用户名获取用户信息
     * @param $username
     * @return array|false|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAdminUserByUserName($username){

        if (empty($username)){

            return false;

        }

        $where = [

          'username'    =>trim($username)

        ];
        $userInfo   =   $this->where($where)->find();

        return  $userInfo;

    }

    /**
     * 根据用户id修改登录信息
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id,$data=[]){

        if (empty($id) || empty($data) ||!is_array($data)){

            return false;

        }

        $where = [
            'admin_id' => intval($id)
        ];

        $res = $this->where($where)->save($data);

        return $res;
    }
}