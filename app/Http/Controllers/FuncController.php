<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;

class FuncController
{
    /**
     * PHP 函数的静态调用可以替代if...else
     * @param Request $request
     */
    public function index(Request $request){
        $type=$request->type;
        // 动态调用,第二个参数为回调函数的参数
        // 可以支持引用传值，需要将引用参数放到数组中
        call_user_func_array([$this,$type],['B','C']);
    }
    // 回调函数
    public function A($type){
        dd($type);
    }
    // 回调函数
    public function B(...$type){
        dd($type);
    }
}