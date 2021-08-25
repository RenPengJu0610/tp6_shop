<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/1/3/21:26
 */

namespace app\common\lib;

class Time
{
    public static function userLoginExpiresTime($type = 2)
    {
        $type = !in_array($type, [1, 2]) ? 2 : $type;
        if ($type == 1) {
            $day = $type * 7;
        } elseif ($type == 2) {
            $day = $type * 15;
        }

        return $day * 24 * 3600;
    }
}