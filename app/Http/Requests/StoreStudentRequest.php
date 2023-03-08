<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'room_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'image' => 'required',
            'birthday' => 'required',
            'status' => 'required',
        ];
        return $rules;
    }
    public function messages(){
        $messages =[
            'name.required' => 'Hãy Nhập Họ Và Tên',
            'phone.required' => 'Hãy Nhập Số Điện Thoại',
            'room_name.required' => 'Hãy Nhập Tên Phòng',
            'email.required' => 'Hãy Nhập Email',
            'email.email' => 'Email Chưa Đúng Định Dạng',
            'password.required' => 'Hãy Nhập Mật Khẩu',
            'image.required' => 'Chưa Tải Ảnh Lên',
            'birthday.required' => 'Hãy Nhập Ngày Sinh',
            'status.required' => 'Hãy Nhập Trạng Thái',
        ];
        return $messages;
    }
}
