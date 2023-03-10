<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileStudentRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'birthday' => 'required',
        ];
        return $rules;
    }
    public function messages(){
        $messages =[
            'name.required' => 'Hãy Nhập Họ Và Tên',
            'phone.required' => 'Hãy Nhập Số Điện Thoại',
            'email.required' => 'Hãy Nhập Email',
            'email.email' => 'Email Chưa Đúng Định Dạng',
            'birthday.required' => 'Hãy Nhập Ngày Sinh',
        ];
        return $messages;
    }
}
