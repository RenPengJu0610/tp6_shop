<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/24/17:19
 */

namespace app\common\model\mysql;


use think\Model;

class BaseModel extends Model
{

    // 根据id 修改数据
    public function getByIdUpdate($id,$data){
        $where = [
            'id'    =>  $id,
        ];
        $data['update_time'] = time();

        return $this->where($where)->save($data);
    }
}