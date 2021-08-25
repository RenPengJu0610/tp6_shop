<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/10/11:11
 */

namespace app\common\business;


use think\Exception;
use think\facade\Log;

class BusBase
{
    // 根据id查询一条数据
    public function getById($id){

        $res = $this->Model->find($id);

        if (!$res){
            return [];
        }

        return $res;

    }
    // 添加数据
    public function add($data){

        $data['status'] = config('status.mysql.table_normal');
        try {
            $this->Model->save($data);
        }catch (\Exception $e){
            return 0;
        }
        return $this->Model->id;
    }

    // 修改排序
    public function listOrder($data = []){
        $res = $this->getById($data['id']);

        if (!$res){
            throw new Exception('不存在该数据');
        }

        try {
            $result = $this->Model->getByIdUpdate($data['id'],$data);
        }catch (\Exception $e){
            //记录错误日志
            Log::error('goods-listOrder-'.$e->getMessage(),[],$e->getMessage());
            return false;
        }
        return $result;
    }

    public function status($data){

        $res = $this->getById($data['id']);

        if (!$res){
            return show(config('status.error'),'没有该记录');
        }

        if ($res['status'] == $data['status']){
            throw new Exception('未发生修改');
        }

        try {
            $result = $this->Model->getByIdUpdate($data['id'],$data) ;
        }catch (\Exception $e){
            Log::error('getByIdUpdateStatusOrindexImagStatus-'.$e->getMessage(),[],$e->getMessage());
            return false;
        }

        return $result;
    }
}