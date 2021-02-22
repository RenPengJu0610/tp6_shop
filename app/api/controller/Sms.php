<?php

declare(strict_types=1);

namespace app\api\controller;


use app\BaseController;

use app\common\business\Sms as SmsBli;
use think\facade\Cache;

class Sms extends BaseController
{

    public function code() :object{

        $phoneNumber = $this->request->param('phone_number','','trim');

        $data = [
          'phone_number' => $phoneNumber
        ];
        try {
            validate(\app\api\validate\User::class)->scene('send_code')->check($data);
        }catch (\think\exception\ValidateException $e){

            return show(config('status.error'),$e->getError());
        }
        $number = Cache::get('phone_sms');
        if (empty($number) || $number <2){
            $relut = SmsBli::sendCode($phoneNumber,'baidu');
            Cache::inc('phone_sms',1);
        }else{
            $relut = SmsBli::sendCode($phoneNumber,'tencent');
            Cache::inc('phone_sms');
        }

        if (Cache::get('phone_sms') > 9){
            Cache::delete('phone_sms');
        }


        if ($relut){
            return show(config('status.success'),'OK');
        }

        return show(config('status.error'),'发送短信验证码失败');
    }

}