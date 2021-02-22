<?php

//declare(strict_types = 1);

/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2020/12/28/20:14
 */
namespace app\common\lib;

class Str{
    /**
     * 生成登录需要的Token
     * @param $string
     * @return string
     * @date 2021/1/3/21:07
     * @author RenPengJu
     */
    public static function getLoginToken(  $string ){

        $str = md5(uniqid(md5(microtime(true)),true));

        $token = sha1($str.$string);

        return $token;

    }
}