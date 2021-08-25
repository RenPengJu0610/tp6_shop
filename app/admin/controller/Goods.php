<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/6/4/23:12
 */

namespace app\admin\controller;


use app\common\business\GoodsSku;
use think\facade\View;
use app\common\business\Goods as GoodsBus;

class Goods extends AdminBase
{
    /**
     * 商品列表展示
     * @return string
     * @date 2021/7/17/9:20
     * @author RenPengJu
     */
    public function index()
    {
        $data = [];
        $time = $this->request->param('time', '');
        $title = $this->request->param('title', '');
        $seach = [
            'time' => $time,
            'title' => $title
        ];
        if (!empty($time)) {
            $data['create_time'] = explode(' - ', $time);
            $seach['time'] = $time;
        }
        if (!empty($title)) {
            $data['title'] = $title;
            $seach['title'] = $title;
        }
        $goods = (new GoodsBus())->getLists($data, 5);

        return View::fetch('',
            [
                'goods' => $goods,
                'seach' => $seach
            ]
        );
    }

    public function listorder()
    {
        $id = $this->request->param('id', 0, 'intval');
        $listorder = $this->request->param('listorder', 0, 'intval');
        $data = [
            'id' => $id,
            'listorder' => $listorder
        ];
        $result = (new GoodsBus())->listOrder($data);

        if ($result) {
            return show(config('status.success'), '排序成功');
        } else {
            return show(config('status.error'), '排序失败');
        }
    }

    public function status()
    {
        $id = $this->request->param('id', 0, 'intval');
        $status = $this->request->param('status', 0, 'intval');
        $data = [
            'id' => $id,
            'status' => $status
        ];
        $result = (new GoodsBus())->status($data);

        if ($result) {
            return show(config('status.success'), '状态修改成功');
        } else {
            return show(config('status.error'), '状态修改失败');
        }
    }


    /**
     * 商品添加逻辑
     * @return \think\response\Json
     * @date 2021/7/17/9:20
     * @author RenPengJu
     */
    public function save()
    {

        $data = $this->request->param();
        $data['category_path_id'] = $data['category_id'];
        $result = explode(",", $data['category_path_id']);
        $data['category_id'] = end($result);
        $res = (new GoodsBus())->insterDate($data);
        if (!$res) {
            return show(config('status.error'), '商品添加失败', []);
        }
        return show(config('status.success'), '商品添加成功', []);

    }

    public function add()
    {
        return View::fetch();
    }
}