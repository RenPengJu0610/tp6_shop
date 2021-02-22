<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/1/11/20:15
 */

namespace app\api\controller;

use app\common\business\User as Userbis;
use think\Exception;

class User extends AuthBase{

    public function index(){
        $user = (new Userbis())->getNormalUserById($this->id);

        $resultUser = [
            'id' => $this->id,
            'username' => $user['username'],
            'sex'   =>  $user['sex']
        ];
        return show(config('status.success'),'OK',$resultUser);
    }

    public function update(){

        $username = $this->request->param('username','','trim');

        $sex    =   $this->request->param('sex',1,'intval');


        $validata = [
          'username'    =>  $username,
          'sex'     =>  $sex
        ];

        try {
            validate(\app\api\validate\User::class)->scene('updateusername')->check($validata);
        }catch (\Exception $e){
            return show(config('status.error'),$e->getMessage());
        }

        $user = (new Userbis())->update($this->id,$validata);

        if (!$user){
           return show(config('status.error'),'修改失败');
        }

        return show(config('status.success'),'OK',$user);

    }
}