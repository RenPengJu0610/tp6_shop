<?php


namespace app\api\controller;


class Error
{
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return show(config('status.methon_not_defined'),'找不到改控制器',[],404);
    }
}