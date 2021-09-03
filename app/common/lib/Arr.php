<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/5/22/22:59
 */

namespace app\common\lib;


class Arr
{
    public static function getTree($data = [])
    {
        $items = [];

        foreach ($data as $value) {
            $items[$value['category_id']] = $value;
        }
        $tree = [];


        foreach ($items as $id => $item) {
            if (isset($items[$item['pid']])) {
                $items[$item['pid']]['list'][] = &$items[$id];
            } else {
                $tree[] = &$items[$id];
            }
        }
        /*
         *  $items=[
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
        foreach ($items as $id => $item){
            if (isset($items[$item['pid']])){
                $items[$item['pid']]['list'][] = &$items[$id];
            }else{
                $tree[] = &$items[$id];
            }
            return  $tree;
        }
        }*/

        return $tree;
    }

    /**
     * 按相应的规则截取无限极分类的树形结构数据
     * @param $data 无限极分类的数据
     * @param int $firstCount 要截取的长度
     * @param int $secondCount 要截取的长度
     * @param int $threeCount 要截取的长度
     * @return array
     * @date 2021/8/26/17:52
     * @author RenPengJu
     */
    public static function sliceTreeArr($data, $firstCount = 5, $secondCount = 3, $threeCount = 5)
    {
        $data = array_slice($data, 0, $firstCount);
        foreach ($data as $k => $v) {
            if (!empty($v['list'])) {
                $data[$k]['list'] = array_slice($v['list'], 0, $secondCount);
                foreach ($v['list'] as $kk => $vv) {
                    if (!empty($vv['list'])) {
                        $data[$k]['list'][$kk]['list'] = array_slice($vv['list'], 0, $threeCount);
                    }
                }
            }
        }
        /*$data = array_slice($data,0,$firstCount);
        foreach ($data as $k => $v){
            if (!empty($v['list'])){
                $data[$k]['list'] = array_slice($v['list'],0,$threeCount);
                foreach ($v['list'] as $kk => $vv){
                    if (!empty($vv['list'])){
                        $data[$k]['list'][$kk]['list'] = array_slice($vv['list'],0,$secondCount);
                    }
                }
            }
        }*/
        return $data;
    }

    /**
     * 分页默认返回的数据
     * @param $num
     * @return array
     * @date 2021/7/17/9:32
     * @author RenPengJu
     */
    public static function getPaginateDefaultData($num)
    {
        return $data = [
            'total' => 0,
            'per_page' => $num,
            'current_page' => 1,
            'last_page' => 0,
            'data' => []
        ];
    }
}