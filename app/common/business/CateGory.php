<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/5/13/14:48
 */

namespace app\common\business;

use app\common\lib\Show;
use app\common\model\mysql\CateGory as CateGoryModel;
use think\Exception;
use think\facade\Log;

class CateGory
{

    public $Model = null;

    public function __construct()
    {
        $this->Model = new CateGoryModel();
    }

    /**
     * 分类添加
     * @param $data
     * @return mixed
     * @date 2021/5/14/9:34
     * @author RenPengJu
     */
    public function add($data)
    {

        $data['status'] = config('status.mysql.table_normal');
        $data['ctime'] = time();
        $data['utime'] = time();

        $cname = $data['cname'];

        $cateGoryName = $this->Model->getCateGoryName($cname);
        if (!empty($cateGoryName)) {
            throw new Exception('分类名称已存在，请重新输入');
        }
        try {
            $this->Model->save($data);
        } catch (\Exception $e) {
            throw new Exception('服务器内部异常');
        }
        return $this->Model->getLastInsID();
    }

    /**
     * 获取正常的分类名称
     * @return array
     * @date 2021/5/15/12:30
     * @author RenPengJu
     */
    public function getNormalCateGorys()
    {

        $field = "id,pid,cname";

        $cateGorys = $this->Model->getNormalCateGorys($field);

        if (!$cateGorys) {
            return $cateGorys = [];
        }
        $cateGorys = $cateGorys->toArray();

        return $cateGorys;
    }

    public function getNormalAllCateGorys()
    {

        $field = "id as category_id,pid,cname as name,listorder";

        $cateGorys = $this->Model->getNormalCateGorys($field);

        if (!$cateGorys) {
            return $cateGorys = [];
        }
        $cateGorys = $cateGorys->toArray();

        return $cateGorys;
    }

    public function getCateGoryList($data, $num)
    {

        $list = $this->Model->getCateGoryList($data, $num);

        if (!$list) {
            return \app\common\lib\Arr::getPaginateDefaultData($num);
        }
        $result = $list->toArray();

        $result['render'] = $list->render();

        $pids = array_column($result['data'], 'id');

        if ($pids) {

            $idCountResult = $this->Model->getChildCountInPids(['pid' => $pids]);

            $idCountResult = $idCountResult->toArray();
            $idCount = [];

            foreach ($idCountResult as $countResult) {
                $idCount[$countResult['pid']] = $countResult['count'];
            }

            if ($result['data']) {
                foreach ($result['data'] as $k => $value) {
                    $result['data'][$k]['childcount'] = $idCount[$value['id']] ?? 0;
                }
            }

        }
        return $result;

    }

    public function getById($id)
    {

        $res = $this->Model->find($id);

        if (!$res) {
            return [];
        }

        return $res;
    }

    public function listOrder($data)
    {

        $res = $this->getById($data['id']);

        if (!$res) {
            throw new Exception('不存在该数据');
        }

        try {
            $result = $this->Model->getByIdUpdate($data['id'], $data);
        } catch (\Exception $e) {
            //记录错误日志
            Log::error('listOrder-' . $e->getMessage(), [], $e->getMessage());

            return false;
        }

        return $result;

    }

    public function status($data)
    {

        $res = $this->getById($data['id']);

        if (!$res) {
            return show(config('status.error'), '没有该记录');
        }

        if ($res['status'] == $data['status']) {
            throw new Exception('未发生修改');
        }

        try {
            $result = $this->Model->getByIdUpdate($data['id'], $data);
        } catch (\Exception $e) {
            Log::error('getByIdUpdateStatus-' . $e->getMessage(), [], $e->getMessage());
            return false;
        }

        return $result;


    }

    /**
     * 获取一级分类的内容
     * @param int $pid
     * @param string $field
     * @return array
     * @date 2021/7/4/13:49
     * @author RenPengJu
     */
    public function getNormalByPid($pid = 0, $field = "id,cname,pid")
    {
        try {
            $res = $this->Model->getNormalByPid($pid, $field);
        } catch (\Exception $e) {
            return [];
        }
        $res = $res->toArray();

        return $res;
    }

    public function getNormalDataByCategoryId($categoryId = 0)
    {

        // 根据分类id 获取对应的数据
        try {
            $res = $this->Model->getNormalDataByCategoryId($categoryId);
            if (!$res) {
                throw new Exception('没有相关数据');
            }
            $res = $res->toArray();
            $result = array();
            // 如果pid等于0说明是顶级分类
            if (empty($res['pid'])) {
                $result['name'] = $res['name'];
                // 根据顶级分类id查询该分类下是否存在二级分类子分类
                $field = "id,cname as name";
                $reclassData = $this->Model->getNormalByPid($res['id'], $field);
                $reclassData = $reclassData->toArray();
                if (empty($reclassData)) {
                    $result['focus_ids'] = $res['id'];
                    $result['list'][] = [];
                }
                $result['focus_ids'] = [$res['id'], $reclassData[0]['id']];
                $result['list'][] = $reclassData;
                $list = $this->Model->getNormalByPid($reclassData[0]['id'], $field);
                $list = $list->toArray();
                if (!empty($list)) {
                    $result['list'][] = $list;
                } else {
                    $result['list'][] = [];
                }
            } else {
                // pid不等于0说明是通过点击的二级分类进来的，需要根据Pid查询到父级数据
                $result['name'] = $res['name'];
                $result['focus_ids'] = [$res['pid'], $res['id']];
                $result['list'] = $res;
            }
        } catch (\Exception $e) {
            return Show::fail($e->getMessage());
        }
        return $result;
    }
}