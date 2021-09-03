<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2020/12/22/12:43
 */

namespace app\api\controller;

use app\BaseController;
use app\common\business\Goods as GoodsBus;
use app\common\lib\Show;

class Index extends BaseController
{

    //获取首页大图轮播图
    public function getRotationChart()
    {
        $result = (new GoodsBus())->getRotationChart();

        return show(1, 'OK', $result);
    }

    public function cagegoryGoodsRecommend()
    {
        $cateGoryIds = [
            1,
            2
        ];
        $result = (new GoodsBus())->cagegoryGoodsRecommend($cateGoryIds);

        return Show::success($result);
    }
}