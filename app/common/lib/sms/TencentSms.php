<?php
declare(strict_types=1);

namespace app\common\lib\sms;

use think\facade\Log;

class TencentSms implements SmsBase
{
    /**
     * 腾讯云发送短信验证码的场景
     * @param string $phone
     * @param int $code
     * @return bool
     * @date 2020/12/18/22:52
     * @author RenPengJu
     */
    public static function sendCode(string $phone,int $code) :bool{

        if(empty($phone) || empty($code)){

            return  false;
        }

        try {
            $data = [
              'phone' => $phone,
              'code'  =>    $code
            ];
            print_r($data);
            Log::info("tencentSms-sendCode-{$phone}result".json_encode($data));
        }catch (\Exception $e){
            Log::error("tencent-error-{$phone}",$e->getMessage());
            return false;

        }

        return true;

    }
}