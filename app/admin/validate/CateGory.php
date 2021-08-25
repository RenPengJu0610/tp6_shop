<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/5/13/14:27
 */
namespace app\admin\validate;
use think\Validate;
class CateGory extends Validate{
    protected $rule = [
       'pid' => 'require',
       'cname' => 'require',
        'id'    => 'require|number',
        'listorder' =>  'require|number',
        'status'    =>  ['require','in'=>['1','2','3'],'number']
    ];
    protected $message = [
       'pid.require' => '参数不对',
        'cname.require' => '分类名称必填',
        'id.require' => 'id必填',
        'id.number' => 'id必须是数字',
        'listorder.require' => '排序值必填',
        'listorder.number' => '排序值必需是数字',
        'status.require'    => '状态值必传',
        'status.number'     =>  '状态值必须为数字',
        'status.in'         =>  '状态值不在范围内'
    ];

    protected $scene = [
        'list'=>['id','listorder'],
        'add'   =>  ['pid','cname'],
        'status' => ['id','status']
    ];
}