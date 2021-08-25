<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/8/7/22:27
 */
namespace app\common\lib;
class Show{
    // 成功返回JSON格式的数据
    public static function success($data, $message = 'OK',$httpStatus=200){
        return json([
            'status' => config('status.success'),
            'message' => $message,
            'result' => $data
        ],$httpStatus);
    }
    public static function fail($msg,$status=100,$data = []){
        $arr = [
            'status'=>$status,
            'message'=>$msg,
            'data'=>$data
        ];
    return json($arr);
    }
}