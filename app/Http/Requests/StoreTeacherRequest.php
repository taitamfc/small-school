<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
            'password' => 'required',
            'level' => 'required',
            'status' => 'required',
           ];
            return $rules;
    }
    public function messages(){
        $messages =[
            'name.required' => ':attribute không được để trống',
            'email.required' => ':attribute không được để trống',
            'password.required' => ':attribute không được để trống',
            'level.required' => ':attribute không được để trống',
            'status.required' => ':attribute không được để trống',
            ];
            return $messages;
    }
    }

