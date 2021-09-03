<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/11/14:30
 */

namespace app\common\model\mysql;

use app\common\model\mysql\BaseModel;


class Goods extends BaseModel
{
    protected $table ="mall_goods";

    protected $pk = 'id';

    protected $autoWriteTimestamp = true;

    public function updateById($id,$data){
        $data['update_time'] = time();
        return $this->where(['id' => $id])->save($data);
    }
    public function searchTitleAttr($query,$value){
        $query->where('title', 'like', '%' . $value . '%');
    }
    public function searchCreateTimeAttr($query,$value){
        $query->whereBetweenTime('create_time',$value[0],$value[1]);
    }
    public function getLists($listKey,$data,$num){
        if (!empty($listKey)){
            $res = $this->withSearch($listKey,$data);
        }else{
            $res = $this;
        }
        $order = ['listorder' => 'desc','id' => 'desc'];
        $list = $res->whereIn('status',[1,2])
                     ->order($order)
                     ->paginate($num);
//        echo $this->getLastSql();
        return $list;
    }

    public function getRotationChart($where,$field, $num = 5){
        $order = ['id' => 'desc'];
        return $this->where($where)
                     ->order($order)
                     ->field($field)
                     ->limit($num)
                     ->select();
    }

    public function getImageAttr($value){
        return request()->domain().$value;
    }

    public function getCarouselImageAttr($value){
        if (!empty($value)){
            $value = explode(',',$value);
            $value = array_map(function ($v){
                return request()->domain() . $v ;
            },$value);
        }
        return $value;
    }
    /*
     * 关于tp6 图片路径不显示的问题
     * public function host(bool $strict = false): string
    {
        if ($this->host) {
            $host = $this->host;
        } else {
            $host = strval($this->server('HTTP_X_FORWARDED_HOST') ? : $this->server('HTTP_HOST'));
        }

        return true === $strict && strpos($host, ':') ? strstr($host, ':', true) : $host;
    }*/

    public function getNormalGoodsFindInSetCategoryId($field,$category_id,$limit = 10){
        $order = ['listorder' => 'desc','id' => 'desc'];
        return $this->whereFindInSet('category_path_id',$category_id)
                    ->where('status','=',config('status.mysql.table_normal'))
                    ->order($order)
                    ->field($field)
                    ->limit($limit)
                    ->select();
    }

}