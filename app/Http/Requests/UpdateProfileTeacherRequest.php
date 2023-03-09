<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileTeacherRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required',
           ];
            return $rules;
    }
    public function messages(){
        $messages =[
            'name.required' => ':attribute không được để trống',
            'email.required' => ':attribute không được để trống',
            ];
            return $messages;
    }
}
