<?php
/**
 * Created by PengJu
 * User: RenPengJu
 * Motto: 现在的努力是为了小时候吹过的牛逼
 * Time: 2021/7/10/16:41
 */

namespace app\admin\controller;


class Image extends AdminBase
{

    public function upload(){
        if ($this->request->isPost()){

            $file = $this->request->file('file');

            $fileName = \think\facade\Filesystem::disk('public')->putFile('image',$file);

            if (!$fileName){
                return show(config('status.error'),'上传图片失败');
            }

            $fileUrl = [
                'image' =>  'http://www.youhong.com'.'/upload/'.str_replace('\\','/',$fileName)
            ];
            return show(config('status.success'),'图片上传成功',$fileUrl,200);
        }

    }
    public function layUpload(){
        $file = $this->request->file('file');

        $fileName = \think\facade\Filesystem::disk('public')->putFile('image',$file);

        if (!$fileName){
            return json(['code'=>1,'data'=>[]],200);
        }

        $fileUrl = [
            'code' => 0,
            'data' =>[
                'src' =>  '/upload/'.str_replace('\\','/',$fileName)
            ]
        ];

        return json($fileUrl,200);
    }
}