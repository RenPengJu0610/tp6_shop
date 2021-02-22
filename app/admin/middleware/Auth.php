<?php
declare(strict_types =1 );
namespace app\admin\middleware;

class Auth{

    public function handle($request, \Closure $next)
    {
        // 添加前置中间件执行代码
        if (empty(session(config('session.admin_session'))) && !preg_match('/login/',$request->pathinfo())){

            return redirect((string) url('/admin/login/index'));

    }
        return $next($request);

    }
}