<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $rules = [
            'name'          => 'required',
            'start_time'    => 'required',
            'end_time'      => 'required',
            'teacher_id'    => 'required'
        ];
        if( $this->request->get('recurrence') == 'yes' || $this->request->get('recurrence') == 1 ){
            $rules['end_loop'] = 'required';
        }
        return $rules;
    }
    public function messages(){
        $messages =[
            'required' => 'Trường yêu cầu',
        ];
        return $messages;
    }
}
