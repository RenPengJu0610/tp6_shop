<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2020/12/20/11:23
 */
namespace app\api\exception;

use think\exception\Handle;
use Throwable;
use think\Response;

class Http extends Handle{

    public $httpStatus = 500;
    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        //7-13前端登录逻辑开发（一）
        if ($e instanceof \think\Exception){
            return show($e->getCode(),$e->getMessage());
        }
        //7-17利用authbase处理前端登录场景
        if($e instanceof  \think\exception\HttpResponseException){

            return parent::render($request,$e);
        }

        if (method_exists($e,'httpStatus')){
            $httpStatus = $e->getStatusCode();
        }else{
            $httpStatus = $this->httpStatus;
        }
        // 添加自定义异常处理机制
        return show(config('status.error'),$e->getMessage(),[],$httpStatus);
    }
}