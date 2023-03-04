<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
    public function rules(): array
    {
        $rules =[
            'user_name' => 'required',
            'email' => 'required|email',
            'full_name' => 'required',
            
           ];
            return $rules;
    }
        public function messages(){
            $messages =[
                'user_name.required' => 'Hãy Nhập Tên Đăng Nhập',
                'full_name.required' => 'Hãy Nhập Họ Và Tên',
                'email.required' => 'Hãy Nhập Email',
                'email.email' => 'Email Chưa Đúng Định Dạng',
            ];
            return $messages;
        }
}
