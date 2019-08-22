<?php


namespace App\Handlers;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class ImageUploadHandler
{
    protected $allow_ext = ['png','gif','jpg','jpeg'];

    /**
     * 保存图片
     * @param UploadedFile $file
     * @param $folder
     * @param $file_prefix
     * @return array|bool
     */
    public function save( UploadedFile $file,$folder,$file_prefix,$max_width = false){
        // 是否符合扩展名
        $extension = strtolower($file->getClientOriginalExtension()) ?:'png';
        if(!in_array($extension,$this->allow_ext)){
            return false;
        }
        // 相对类路径
        $folder_name = "upload/images/$folder/".date("Ym/d",time());
        // 绝对路径 保存目录
        $upload_path = public_path().'/'.$folder_name;
        // 文件名
        $file_name = $file_prefix.'_'.time().'_'.Str::random(10).'.'.$extension;
        // 移动图片到相关路径
        $file->move($upload_path,$file_name);
        // 裁剪图片
        if($max_width && $extension != 'gif'){
            $this->reduceSize($upload_path.'/'.$file_name ,$max_width);
        }

        return [
            'path'=>config('app.url')."/$folder_name/$file_name"
        ];

    }

    /**
     * 裁剪图片
     * @param $filepath
     * @param $max_width
     */
    public function reduceSize($filepath,$max_width){
        // 先实例化，传参是文件的磁盘物理路径
        $image =Image::make($filepath);
        // 进行大小调整的操作
        $image->resize($max_width,null,function($constraint){
            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();
            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        // 对图片修改后进行保存
        $image->save();
    }
}