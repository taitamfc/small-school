<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportTeacherRequest extends FormRequest
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
            'importTeacher' => 'required',
           ];
            return $rules;
    }
    public function messages(){
        $messages =[
            'importTeacher.required' => 'Hãy Chọn Tệp Để Import',
            ];
            return $messages;
    }
}
