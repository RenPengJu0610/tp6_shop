<?php

use think\facade\Route;

//发送短信验证码的接口
Route::rule('smscode','sms/code','POST');

Route::resource('user','User');