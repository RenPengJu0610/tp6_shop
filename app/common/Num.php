<?php
/**
 * 和数字相关的基础类库
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2020/12/20/11:03
 */
declare(strict_types=1);

namespace app\common;

class Num{
    public static function code(int $len = 4) :int{

        $code = rand(0000,9999);

        if ($len == 6){
            $code = rand(000000,999999);
        }

        return $code;
    }
}