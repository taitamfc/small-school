<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreEventRequest extends FormRequest
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
        $start_time = $this->request->get('start_time');
        $end_time = $this->request->get('end_time');
        $date1 = Carbon::parse($start_time);
        $date2 = Carbon::parse($end_time);
        $result = $date2->gt($date1);
 

        $rules = [
            'name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'teacher_id' => 'required',
            // 'student_ids' => 'required',
        ];
        if( !$result ){
            $rules['end_time_not_right'] = 'required';
        }
        return $rules;
    }
    public function messages(){
        $messages =[
            'name.required' => 'Hãy Nhập Tên Sự Kiện',
            'start_time.required' => 'Hãy Nhập Thời Gian Bắt Đầu Sự Kiện',
            'end_time.required' => 'Hãy Nhập Thời Gian Kết Thúc Sự Kiện',
            'teacher_id.required' => 'Hãy Chọn Giáo Viên',
            'student_ids.required' => 'Hãy Chọn Học Viên',
            'end_time_not_right.required' => 'Thời gian kết thúc không hợp lệ',
        ];
        return $messages;
    }
}
