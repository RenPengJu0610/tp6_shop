<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/2/6/21:07
 */
namespace app\api\controller;

use think\facade\Cache;

class Logout extends AuthBase{
    public function loginOut(){
        $res = Cache::set(config('redis.token_pre').$this->accessToken,null);

        if ($res){
            return show(config("status.success"),'退出登录成功',[],2000);
        }
        return show(config("status.error"),'退出登录失败',[]);

    }
}