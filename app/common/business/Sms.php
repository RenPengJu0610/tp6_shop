<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2020/12/18/22:54
 */
declare(strict_types=1);

namespace app\common\business;

use app\common\Num;

use app\common\lib\sms\TencentSms;
use app\common\lib\sms\ClassArr;
class Sms
{
    public static function sendCode(string $phone,$type='tencent') :bool{

        $code = Num::code(6);
//        $type = ucfirst($type);
//
//        $obj = "app\common\lib\sms\\".$type."Sms";
//
//        $sms = $obj::sendCode($phone,$code);
        $classStat = ClassArr::smsClassStat();

        $classobj = ClassArr::initClass($type,$classStat);

        $sms = $classobj::sendCode($phone,$code);
        if ($sms){
            //把短信验证码写入到redis中去，设置有效期1分钟内有效
            cache(config('redis.code_pre').$phone,$code,config('redis.code_exprie'));
        }
        return $sms;
    }
}