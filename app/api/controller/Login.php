<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2020/12/22/12:43
 */

namespace app\api\controller;
use app\BaseController;
use app\common\lib\Str;

class Login extends BaseController{

    /**
     * 登录接口
     * @return \think\response\Json
     * @date 2020/12/22/17:14
     * @author RenPengJu
     */
    public function login(){

        if(!$this->request->isPost()){

            return show(config('status.error'),'非法请求');
        }

        $phoneNumber = $this->request->param('phone_number','','trim');

        $code = $this->request->param('code',0,'int');

        $type = $this->request->param('type','1','trim');

        $data = [
            'phone_number'     =>  $phoneNumber,
            'code'      =>  $code,
            'type'      =>  $type
        ];

        try {
            validate(\app\api\validate\User::class)->scene('login')->check($data);
        }catch (\Exception $e){
            return show(config('status.error'),$e->getMessage());
        }

        try {
            $result = (new \app\common\business\User())->login($data);
        }catch (\Exception $e){
            return show(config('status.error'),$e->getMessage());
        }
        if ($result){
            return show(config('status.success'),'登录成功',$result);
        }
        return show(config('status.error'),'登录失败');

    }
}