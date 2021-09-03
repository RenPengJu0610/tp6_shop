<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/4/16:15
 */

namespace app\common\business;

use app\common\model\mysql\SpecsValue as SpecsValueModel;
use think\Exception;

class Specs extends BusBase
{
    public $Model = null;

    public function __construct()
    {
        $this->Model = new SpecsValueModel();
    }

    /**
     * 添加规格值
     * @param $data
     * @return mixed
     * @throws Exception
     * @date 2021/7/4/16:27
     * @author RenPengJu
     */

    public function getNormalBySpecsId($id, $field = 'id,name')
    {
        try {
            $res = $this->Model->getNormalBySpecsId($id, $field);
        } catch (\Exception $e) {
            return [];
        }
        $res = $res->toArray();

        return $res;
    }

    public function dealGoodsSkus($gids, $flagValue)
    {
        $speceValueKeys = array_keys($gids);
        foreach ($speceValueKeys as $speceValueKey) {
            $speceValueKey = explode(',', $speceValueKey);
            foreach ($speceValueKey as $key => $value) {
                $new[$key][] = $value;
                $speceValueIds[] = $value;
            }
        }
        $speceValueIds = array_unique($speceValueIds);
        $speceValues = $this->getNormalInIds($speceValueIds);
        $flagValue = explode(',',$flagValue);

        $result = [];
        foreach ($new as $kk => $vv){
            $specearrs = array_unique($vv);
            $list = [];
            foreach ($specearrs as $specearr){
                $list[] = [
                   'id' => $specearr,
                   'name' => $speceValues[$specearr]['name'],
                   'flag' => in_array($specearr,$flagValue) ? 1 : 0
                ];
            }
            $result[$kk] = [
               'name' => $speceValues[$specearrs[0]]['specs_name'],
               'list' => $list
            ];
        }
        return $result;
    }

    public function getNormalInIds($ids)
    {
        if (!$ids) {
            return [];
        }

        try {
            $result = $this->Model->getNormalInIds($ids);
        } catch (\Exception $e) {
            return [];
        }
        $result = $result->toArray();
        $specsName = config('specs');
        $specsName = array_column($specsName,'name','id');
        $res = [];
        foreach ($result as $key => $value){
            $res[$value['id']] = [
                'name' => $value['name'],
                'specs_name' => $specsName[$value['specs_id']]
            ];
        }
    return $res;
    }
}