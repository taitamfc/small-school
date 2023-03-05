<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportUserRequest extends FormRequest
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
            'importUser' => 'required',
           ];
            return $rules;
    }
    public function messages(){
        $messages =[
            'importUser.required' => 'Hãy Chọn Tệp Để Import',
            ];
            return $messages;
    }
}
