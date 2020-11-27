<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'=>'required|min:6|email',
            'password'=>'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'email.required'=>'Không được để trống email',
            'email.min'=>'Email có ít nhất 6 ký tự',
            'email.email'=>'Cần nhập đúng định dạng email, ví dụ abc@gmail.com',
            'password.required'=>'Mật khẩu không được để trống',
            'password.min'=>'Mật khẩu có ít nhất 6 ký tự'
        ]
    }
}
