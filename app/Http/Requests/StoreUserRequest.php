<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        $rules =[
            'user_name' => 'required',
            'email' => 'required|email',
            'full_name' => 'required',
            'password' => 'required',
            'group_id' => 'required', 
           ];
            return $rules;
    }
    public function messages(){
        $messages =[
            'user_name.required' => 'Hãy Nhập Tên Đăng Nhập',
            'full_name.required' => 'Hãy Nhập Họ Và Tên',
            'email.required' => 'Hãy Nhập Email',
            'email.email' => 'Email Chưa Đúng Định Dạng',
            'password.required' => 'Hãy Nhập Mật Khẩu',
            'group_id.required' => 'Hãy Chọn Chức Vụ',
            ];
            return $messages;
    }
}
