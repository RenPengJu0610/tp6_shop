<?php

use think\facade\Route;
//发送短信验证码的接口
Route::rule('smscode','sms/code','POST');
// 商品详情页接口
Route::rule("detail/:id","mall.detail/index");

Route::resource('user','User');