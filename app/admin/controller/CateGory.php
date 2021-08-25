<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/5/2/17:16
 */

namespace app\admin\controller;

use think\facade\Log;
use think\facade\View;

use app\common\business\CateGory as CateGoryBus;

class CateGory extends Adminbase
{

    /**
     * 分类首页
     * @return string
     * @date 2021/5/2/17:20
     * @author RenPengJu
     */
    public function index()
    {

        /*   //用于理解无限极分类前端树形展示的代码。
           $items=[
              51=> [
                  'categoty_id'=>51,
                  'name'=>'男装',
                     'pid'=>0
               ],
              26 => [
                   'categoty_id'=>26,
                   'name'=>'手机',
                   'pid'=>0,
               ],
               30=> [
                   'categoty_id'=>30,
                   'name'=>'苹guo-2',
                   'pid'=>26
               ],
              41=>[
                  'categoty_id'=>41,
                  'name'=>'男装-2',
                  'pid'=>51
              ]
          ];
          $tree = [];

           foreach ($items as $id => $item){
               if(isset($items[$item['pid']])){
                   $items[$item['pid']]['list'][]=&$items[$id];
               }else{
                   $tree[] = &$items[$id];
               }

           }
           print_r($tree);
   exit();*/

        $pid = $this->request->param('pid', 0, 'intval');

        $data = [
            'pid' => $pid
        ];
        try {
            $cateGory = (new CateGoryBus())->getCateGoryList($data, 5);

        } catch (\Exception $e) {

            $cateGory = \app\common\lib\Arr::getPaginateDefaultData(5);
        }

        return View::fetch("", [

            'category' => $cateGory,
            'pid' => $pid
        ]);

    }

    /**
     * @date 2021/5/2/17:21
     * @author RenPengJu
     * 分类添加
     */
    public function addCateGory()
    {

        if ($this->request->isPost() && $this->request->isAjax()) {

            $pid = $this->request->param('pid', 0, 'intval');

            $name = $this->request->param('name', '', 'trim');

            $data = [
                'pid' => $pid,
                'cname' => $name
            ];


            try {
                validate(\app\admin\validate\CateGory::class)->scene('add')->check($data);
                $addCateGory = new CateGoryBus();
                $result = $addCateGory->add($data);
            } catch (\Exception $e) {
                Log::error('validata-add-' . $e->getMessage(), [], $e->getMessage());
                return show(config('status.error'), $e->getMessage());
            }

            return show(config('status.success'), '添加成功', [], 200);


        } else {
            try {
                $categorys = (new CateGoryBus())->getNormalCateGorys();

            } catch (\Exception $e) {

                $categorys = [];
            }

            return View::fetch('', [
                'categorys' => json_encode($categorys, JSON_UNESCAPED_UNICODE)
            ]);
        }

    }

    public function listOrder()
    {

        $id = $this->request->param('id', 0, 'intval');

        $listOrder = $this->request->param('listorder', 0, 'intval');

        $data = [
            'id' => $id,
            'listorder' => $listOrder
        ];

        try {
            validate(\app\admin\validate\CateGory::class)->scene('list')->check($data);
            $result = (new CateGoryBus())->listOrder($data);
        } catch (\Exception $e) {
            Log::error('validata-listorder-' . $e->getMessage(), [], $e->getMessage());

            return show(config('status.error'), $e->getMessage());
        }

        if ($result) {
            return show(config('status.success'), '排序成功');
        } else {
            return show(config('status.error'), '排序失败');
        }

    }

    /**
     * @date 2021/5/16/13:53
     * @author RenPengJu
     * 修改分类状态的逻辑
     */
    public function status()
    {

        $id = $this->request->param('id', 0, 'intval');

        $status = $this->request->param('status', 0, 'intval');

        $data = [
            'id' => $id,
            'status' => $status
        ];

        try {

            validate(\app\admin\validate\CateGory::class)->scene('status')->check($data);

            $res = (new CateGoryBus())->status($data);

        } catch (\Exception $e) {
            Log::error('updateStatus-' . $e->getMessage(), [], $e->getMessage());

            return show(config('status.error'), $e->getMessage());

        }

        if ($res) {
            return show(config('status.success'), '状态修改成功');
        } else {
            return show(config('status.error'), '状态修改失败');
        }

    }

    public function dialog()
    {
        $cateGorys = (new CateGoryBus())->getNormalByPid();
        return View::fetch("",
            ['categorys' => json_encode($cateGorys, JSON_UNESCAPED_UNICODE)]
        );
    }

    public function getByPid()
    {
        $pid = $this->request->param('pid', 0, 'intval');
        $categorys = (new CateGoryBus())->getNormalByPid($pid);
        return show(config('status.success'), 'OK', $categorys);
    }


}