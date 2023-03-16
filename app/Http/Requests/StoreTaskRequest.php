<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'end_loop' => 'required',
            'status' => 'required',
            'event_name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'teacher_id' => 'required',
            'fee' => 'required',
            'student_ids' => 'required',

           ];
            return $rules;
    }
    public function messages(){
        $messages =[
            'name.required' => 'Hãy Nhập Tiêu Đề',
            'end_loop.required' => 'Hãy Chọn Ngày Kết Thúc',
            'status.required' => 'Hãy Chọn Trạng Thái',
            'event_name.required' => 'Hãy Nhập Tên Sự Kiện',
            'start_time.required' => 'Hãy Nhập Thời Gian Bắt Đầu Sự Kiện',
            'end_time.required' => 'Hãy Nhập Thời Gian Kết Thúc Sự Kiện',
            'teacher_id.required' => 'Hãy Chọn Giáo Viên',
            'fee.required' => 'Hãy Nhập Tiền Công',
            'student_ids.required' => 'Hãy Chọn Học Viên',

            ];
            return $messages;
    }
}
