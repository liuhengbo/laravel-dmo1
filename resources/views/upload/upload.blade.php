<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>上传</title>
    <!-- Styles -->
    <style>

    </style>
</head>
<body>
<div>
{{--    错误提示--}}
    <div>
        @if ($errors->has('image'))
            <strong>{{$errors->first('image')}}</strong>
        @endif
    </div>

    <form action="{{url('upload/image')}}" accept-charset="UTF-8" enctype="multipart/form-data" method="post" >
        @csrf
        <input type="file" name="image" value="上传图片" />
        <button type="submit">提交</button>
    </form>
</div>
</body>
</html>
