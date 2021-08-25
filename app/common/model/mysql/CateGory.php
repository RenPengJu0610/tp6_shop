<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/5/13/14:55
 */

namespace app\common\model\mysql;


use think\Model;

class CateGory extends Model
{
    protected $table = "mall_category";

    protected $pk = 'id';

    protected $autoWriteTimestamp = true;

    public function getNormalCateGorys($field = "*")
    {
        $where = [
            'status' => config('status.mysql.table_normal')
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        $result = $this->where($where)
            ->field($field)
            ->order($order)
            ->select();

        return $result;

    }

    /**
     * 查询分类名称是否存在
     * @param $cname
     * @return array|false|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @date 2021/5/14/10:49
     * @author RenPengJu
     */
    public function getCateGoryName($cname)
    {
        if (empty($cname)) {
            return false;
        }

        $where = [
            'cname' => $cname
        ];

        return $this->where('status', '<>', config('status.mysql.table_delete'))
            ->where($where)
            ->find();
    }

    public function getCateGoryList($where, $num = 10)
    {
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        $result = $this->where('status', '<>', config('status.mysql.table_delete'))
            ->where($where)
            ->order($order)
            ->paginate($num);

//        echo $this->getLastSql();exit();
        return $result;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     * @date 2021/5/15/21:36
     * @author RenPengJu
     * 根据id 修改列表排序
     */
    public function getByIdUpdate($id, $data)
    {
        $where = [
            'id' => $id,
        ];
        $data['utime'] = time();

        return $this->where($where)->save($data);
    }

    /**
     * @date 2021/5/17/12:58
     * @author RenPengJu
     * 根据pid求子分类
     */
    public function getChildCountInPids($condition)
    {

        $where = [
            ['pid', 'in', $condition['pid']],
            ['status', '<>', config('status.mysql.table_delete')]
        ];
        $res = $this->where($where)
            ->field(['pid', 'count(*) as count'])
            ->group('pid')
            ->select();
//        echo $this->getLastSql();exit();
        return $res;

    }

    public function getNormalByPid($pid = 0, $field)
    {
        $where = [
            'pid' => $pid,
            'status' => config('status.mysql.table_normal')
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        $res = $this->where($where)
            ->field($field)
            ->order($order)
            ->select();

        return $res;
    }

    public function getByCateGoryIdNromalList($categoryid)
    {
        if (!$categoryid) {
            return [];
        }
        $field = 'id as category_id,cname as name';
        $result = $this->where(['status' => config('status.mysql.table_normal')])
            ->where('id', '=', $categoryid)
            ->field($field)
            ->find()
            ->toArray();

        $result['list'] = $this->getNormalCateList($categoryid, $field);
        return $result;
    }

    public function getNormalCateList($categoryid, $field = true)
    {
        $where['status'] = [config('status.mysql.table_normal')];
        $where['pid'] = $categoryid;
        return $this->where($where)->field($field)->select()->toArray();
    }

    public function getNormalDataByCategoryId($categoryId)
    {
        $where['status'] = config('status.mysql.table_normal');
        $where['id'] = $categoryId;
        return $this->where($where)->field('cname as name,id,pid')->find();
    }
}