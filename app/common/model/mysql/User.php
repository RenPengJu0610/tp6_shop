<?php


namespace app\common\model\mysql;


use think\Model;

class User extends Model
{
    protected $table ="mall_user";

    protected $pk = 'id';

    protected $autoWriteTimestamp = true;
    /**
     * 根据用户名获取用户信息
     * @param $username
     * @return array|false|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserByPhone($phone_number){

        if (empty($phone_number)){

            return false;
        }

        $where = [

          'phone_number'    =>$phone_number

        ];

        $userInfo   =   $this->where($where)->find();
        return  $userInfo;

    }

    /**
     * 通过ID获取用户数据
     * @param $id
     * @return array|false|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @date 2021/1/20/10:21
     * @author RenPengJu
     */
    public function getUserById($id){
        $id = intval($id);
        if (!$id){
            return false;
        }
        return $this->find($id);
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
            'id' => intval($id)
        ];

        $res = $this->where($where)->save($data);

        return $res;
    }

    public function getUserByUsername($userName){

        if (empty($userName)){

            return false;
        }

        $where = [

            'username'    =>$userName

        ];

        $userInfo   =   $this->where($where)->find();
        return  $userInfo;

    }
}