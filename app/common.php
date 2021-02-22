<?php
// 应用公共文件
/**通用化API数据格式输出
 * @param int $status
 * @param string $message
 * @param array $data
 * @param int $httpStatus
 * @return \think\response\Json
 */
function show($status=200,$message='error',$data=[],$httpStatus=200){

    $result = [
      'status'=>$status,
      'message'=>$message,
      'data'=>$data
    ];

    return json($result,$httpStatus);
}

function fail($msg,$status=100,$data = []){
    $arr = [
      'status'=>$status,
      'message'=>$msg,
      'data'=>$data
    ];
    echo json_encode($arr);exit();
}

function success($data=[],$status=200,$message='ok'){
    return [
        'status'=>$status,
        'message'=>$message,
        'data'=>$data
    ];
}
