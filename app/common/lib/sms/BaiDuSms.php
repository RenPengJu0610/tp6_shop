<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2020/12/20/21:38
 */

declare(strict_types=1);

namespace app\common\lib\sms;

class BaiDuSms implements SmsBase {

    public static function sendCode(string $phone,int $code){

        return true;
    }
}