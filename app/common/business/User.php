<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2020/12/25/20:48
 */
namespace app\common\business;
use app\common\lib\Time;
use  app\common\model\mysql\User as UserModel;
use think\Exception;
use think\facade\Cache;
use app\common\lib\Str;
class User{
    public $Model = null;

    /**
     * 实例化用户模型
     * User constructor.
     */
    public function __construct()
    {
        $this->Model =  new UserModel();
    }


    public function login($data){

        $redisCode = Cache::get(config('redis.code_pre').$data['phone_number']);

        if ( empty($redisCode) || $redisCode != $data['code']){
//            throw new \think\Exception('该验证码不存在或已失效',-1001);
        }
        $userInfo = $this->Model->getUserByPhone($data['phone_number']);

        if (empty($userInfo)){

            $userName = 'pengju_粉_'.$data['phone_number'];
            $data = [
                'username'  =>  $userName,
                'phone_number'=>    $data['phone_number'],
                'type'      =>  $data['type'],
                'status'    =>  config('status.mysql.table_normal')
            ];

            try {
                $this->Model->save($data);
                $userId = $this->Model->id;
            }catch (\Exception $e){
                throw new \think\Exception('数据库异常');
            }

        }else{
            $userId = $userInfo->id;
            $login_data = [
                'update_time'   =>  time(),
                'last_login_time'   =>  time(),
                'last_login_ip'     =>  request()->ip()
            ];

            try {
                 $this->Model->updateById($userId,$login_data);
            }catch (\Exception $e){
                throw new \think\Exception($e->getMessage());
            }
        }

        $token = Str::getLoginToken($data['phone_number']);

        $redisData = [
            'id'   =>  $userId,
            'username'  =>  $userInfo['username']
        ];

        $res = Cache::set(config('redis.token_pre').$token,$redisData,Time::userLoginExpiresTime($data['type']));

        return $res ? ['token' => $token,'username'=>$userInfo['username']] : false;

    }

    /**
     * 根据Id返回正常用户数据
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @date 2021/1/20/10:25
     * @author RenPengJu
     */
    public function getNormalUserById($id){

        $user = $this->Model->getUserById($id);

        if (!$user || $user->status != config('status.mysql.table_normal')){
            return [];
        }
        return $user->toArray();
    }

    public function getNormalUserByUserName($username){

        $userInfo = $this->Model->getUserByUsername($username);
        if (!$userInfo || $userInfo->status != config('status.mysql.table_normal')){
            return  [];
        }
        return $userInfo->toArray();
    }
    public function update($id,$data){
        $user = $this->getNormalUserById($id);

        if (!$user){
            throw new \think\Exception('不存在该用户');
        }
        //检测用户名是否存在

        $UserResult = $this->getNormalUserByUserName($data['username']);

        if ($UserResult && $UserResult['id'] != $id){
            throw new Exception('该用户名已经存在');
        }

        $result =  $this->Model->updateById($id,$data);

        if (!$result){
            throw new Exception('未发生修改');
        }
        return true;

    }
}