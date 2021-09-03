<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/4/16:20
 */

namespace app\common\model\mysql;


use think\Model;

class SpecsValue extends BaseModel
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'mall_specs_value';
    /**
     * 根据规格值名称查询是否已存在
     * @param $name
     * @return false
     * @date 2021/7/4/16:24
     * @author RenPengJu
     */
    public function getSpecsValueName($name){
        if (empty($name)){
            return false;
        }

        $where = [
            'name' => $name
        ];

        return  $this->where('status','<>',config('status.mysql.table_delete'))
            ->where($where)
            ->find();
    }

    public function getNormalBySpecsId($specs_id = 0, $field){
        $where = [
            'specs_id'    =>  $specs_id,
            'status'      => config('status.mysql.table_normal')
        ];

        $res = $this->where($where)
            ->field($field)
            ->select();
        return $res;

    }
}