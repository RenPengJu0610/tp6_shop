<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2020/12/21/15:03
 */
namespace app\common\lib\sms;

class ClassArr {
    public static function smsClassStat(){
        return [
            "baidu" =>  "app\common\lib\sms\BaiDuSms",
            "jd" =>  "app\common\lib\sms\JdSms",
            "tencent" =>  "app\common\lib\sms\TencentSms"
        ];
    }

    public static function initClass($type,$classs,$params = [],$needInstance = false){

        if (!array_key_exists($type,$classs)){
            return false;
        }
        $className = $classs[$type];

        return  $needInstance == true ? (new \ReflectionClass($className))->newInstanceArgs($params) : $className;
    }
}