<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/4/16:15
 */

namespace app\common\business;

use app\common\model\mysql\SpecsValue as SpecsModel;
use think\Exception;

class Specs extends BusBase
{
    public $Model = null;
    public function __construct()
    {
        $this->Model = new SpecsModel();
    }

    /**
     * 添加规格值
     * @param $data
     * @return mixed
     * @throws Exception
     * @date 2021/7/4/16:27
     * @author RenPengJu
     */


    public function getNormalBySpecsId($id,$field = 'id,name'){
        try {
           $res = $this->Model->getNormalBySpecsId($id,$field);
        }catch (\Exception $e){
            return [];
        }
        $res = $res->toArray();

        return $res;
    }
}