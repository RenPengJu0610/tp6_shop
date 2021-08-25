<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/15/15:42
 */

namespace app\admin\controller;

class Arithmetic
{
    function King( $monkeys , $kill ){

        while( count( $monkeys ) > 1){
            echo '长度为'. count( $monkeys).'<br/>';
            print_r($monkeys);
            echo '<hr/>';
            foreach( $monkeys as $k => $v ){
                if( $k % $kill == 2 ){
                    echo '第'.$v.'只猴子被杀了<br/>';
                    unset( $monkeys[$k] );
                    break;
                }else{
                    unset( $monkeys[$k] );
                    $monkeys[] = $v;
                }
            }
        }
        echo '第'. print_r( $monkeys ).'成为大王';
    }

/*$arr = range( 1,3 );
King( $arr , 3 );*/
    public function index()
    {
        $a = "hihaha";
        $b = &$a;
        $c = '1235';
        $a = &$c;
        echo $b;
        /*$a = "hihaha";
        $b = &$a;
        $c = "eita";
        $a = &$c;
        echo    $a;*/
       // return $a.$b;
//        $info = array(1, 2, 3, 4);

//        $i = 1000;
//        switch ($i) {
//            case 0:
//                echo "i equals 0";
//                break;
//            case 1:
//                echo "i equals 1";
//                break;
//            case 2:
//                echo "i equals 2";
//                break;
//            default:
//                echo "i is not equal to 0, 1 or 2";
//        }
//        switch ($i) {
//            case 0:
//            case 1:
//            case 2:
//                echo "i is less than 3 but not negative";
//                break;
//            case 3:
//                echo "i is 3";
//        }
//        switch ($i) {
//            case "apple":
//                echo "i is apple";
//                break;
//            case "bar":
//                echo "i is bar";
//                break;
//            case "cake":
//                echo "i is cake";
//                break;
//        }
//        switch ($i) {
//            case 0:
//                echo "i equals 0";
//                break;
//            case 1:
//                echo "i equals 1";
//                break;
//            case 2:
//                echo "i equals 2";
//                break;
//        }
            /*while (list ($key, $value) = each($info)) {
                if (!($key % 2)) { // skip odd members
                    continue;
                }
                do_something_odd($value);
            }*/
            /* $info = array(1,2,3,4);
             foreach ($info as &$value){
                 $value = $value*2;
             }
             unset($value);

             foreach ($info as $key=>$value){
                 //echo "{$key} => {$value}";
                 var_dump($info);
             }*/
            //unset($value);
            // var_dump($info);exit();
//        list(,,$coffee) = $info;
//        echo $coffee;
            //return $info;

    }

        // 冒泡排序 末尾比较
        function bubblingSort($arr)
        {

            //$arr = [9,6,1,3,10,15,5,4,7];

            /* $num = count($arr);
             // 正向遍历数组
             for ($i = 1; $i < $num; $i++) {
                 // 反向遍历
                 for ($j = $num - 1; $j >= $i ; $j--) {
                     // 相邻两个数比较
                     if ($arr[$j] < $arr[$j-1]) {
                         // 暂存较小的数
                         $iTemp = $arr[$j-1];
                         // 把较大的放前面
                         $arr[$j-1] = $arr[$j];
                         // 较小的放后面
                         $arr[$j] = $iTemp;
                     }
                 }
             }*/
            $count = count($arr);
            for ($i = 1; $i <= $count; $i++){
                for ($j = $count - 1; $j <= $i; $j--){
                    if ($arr[$j] < $arr[$j-1]){
                        $item = $arr[$j - 1];
                        $arr[$j-1] = $arr[$j];
                        $arr[$j] = $item;
                    }
                }
            }
            return $arr;
        }

        // 冒泡排序 首位开始比较
        function bubblingsSort($arr)
        {
            // $arr = [9,6,1,3,10,15,5,4,7];
            /*$count = count($arr);
            if ($count < 2) {
                return $arr;
            }
            for ($i = 0; $i < $count; $i++) {
                for ($j = $i + 1; $j < $count; $j++) {
                    if ($arr[$i] > $arr[$j]) {
                        $tmp = $arr[$i];
                        $arr[$i] = $arr[$j];
                        $arr[$j] = $tmp;
                    }
                }
            }
            return $arr;*/
            $count = count($arr);
            for ($i = 0; $i <= $count; $i++){
                for ($j = $i+1; $j <= $count; $j++){
                    if ($arr[$i] < $arr[$j]){
                        $item = $arr[$i];
                        $arr[$i] = $arr[$j];
                        $arr[$j] = $item;
                    }
                }
            }
            return $arr;
        }

        // 插入法排序
        function insertSort($arr)
        {
            //$arr = [9,6,1,3,10,15,5,4,7];
            /* $num=count($arr);
             for($i=1;$i<$num;$i++) {
                 $tmp=$arr[$i];
                 $j=$i-1;
                 while($arr[$j]>$tmp) {
                     $arr[$j+1]=$arr[$j];
                     $arr[$j]=$tmp;
                     $j--;
                     if($j<0)
                         break;
                 }
             }
             return $arr;*/
            $count = count($arr);
           for ($i = 1; $i < $count; $i++){
               $item = $arr[$i];
               $j = $i - 1;
               while($arr[$j] > $item){
                   $arr[$j + 1] = $arr[$j];
                   $arr[$j] = $item;
                   $j--;
                   if ($j < 0){
                       break;
                   }
               }
           }
        }

        // 选择排序
        function selectSort($arr)
        {
            //$arr = [9,6,1,3,10,15,5,4,7,18];
            $count = count($arr);
            if ($count < 2) {
                return $arr;
            }
            /* for ($i = 0; $i < $count; $i++) {
                 $min = $i;
                 for ($j = $i + 1; $j < $count; $j++) {
                     if ($arr[$min] > $arr[$j]) {
                         $min = $j; //找到最小的那个元素的下标
                     }
                 }
                 if ($min != $i) {//如果下标不是$i 则互换。
                     $tmp = $arr[$i];
                     $arr[$i] = $arr[$min];
                     $arr[$min] = $tmp;
                 }
             }*/
            for ($i = 0; $i <= $count; $i++){
                $min = $i;
                for ($j = $i + 1; $j <= $count; $j++){
                    if ($arr[$min] > $arr[$j]){
                        $min = $j;
                    }
                }
                if ($min != $i){
                    $item = $arr[$i];
                    $arr[$i] = $arr[$min];
                    $arr[$min] = $item;
                }
            }
            return $arr;
        }

        // 快速排序
        function mySort($arr)
        {

            $count = count($arr);
            if ($count < 2) {
                return $arr;
            }
            $key = $arr[0];//选择第一个元素作为比较元素，可选其他
            $left = array();
            $right = array();
            for ($i = 1; $i < $count; $i++) {
                if ($key >= $arr[$i]) {
                    $left[] = $arr[$i];
                } else {
                    $right[] = $arr[$i];
                }
            }
            $left = mySort($left);
            $right = mySort($right);
            $result = array_merge($left, $right);
            return $result;
        }

}


//$arr = [9,6,1,3,10,15,5,4,7,18];
//$obj = new Arithmetic();
//print_r($obj->index(...['haha','bili']));