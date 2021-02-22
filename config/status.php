<?php
return [
    'success' => 200,
    'error'   => 0,
    'not_login'=>-1,
    'methon_not_defined' => -2,
    'request_not_error'=>-3,
    'userinfo_not_null'=>4,
    //MYSQL相关的配置
    'mysql'=>[
        'table_normal'  =>  1,  //1正常
        'table_pending' =>  2,   //待审核
        'table_delete'  =>  3,  //已删除
    ]
];
