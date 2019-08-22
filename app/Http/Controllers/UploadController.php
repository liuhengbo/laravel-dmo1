<?php


namespace App\Http\Controllers;



use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UploadController
{
    /**
     * 上传图片页面
     */
    public function show(){
        return view('upload/upload');
    }
    public function upload(Request $request,ImageUploadHandler $imageUploadHandler,UploadRequest $uploadRequest){
        $res = $imageUploadHandler->save($request->image,'demo1','demo1','300');
        echo "<image src='".Arr::get($res,'path')."'/>";
    }

}