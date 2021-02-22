<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2020/12/20/11:23
 */
namespace app\admin\exception;

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
        if (method_exists($e,'httpStatus')){
            $httpStatus = $e->getStatusCode();
        }else{
            $httpStatus = $this->httpStatus;
        }
        // 添加自定义异常处理机制
        return show(config('status.error'),$e->getMessage(),[],$httpStatus);
    }
}