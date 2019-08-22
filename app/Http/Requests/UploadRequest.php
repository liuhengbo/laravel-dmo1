<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image'=>'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208'
        ];
    }

    public function messages()
    {
        return [
            'image.mimes'=>'只允许上传固定格式图片',
            'image.dimensions'=>'只允许上传大于208*208',
        ];
    }
}
