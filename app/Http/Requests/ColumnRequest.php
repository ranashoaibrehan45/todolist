<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColumnRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'title' => 'required|min:3|max:255|unique:columns',
                ];
                break;
            
            case 'PUT':
                return [
                    'title' => 'required|min:3|max:255|unique:columns,title,'. $this->route('column')->id,
                ];
                break;
            
            default:
                # code...
                break;
        }
    }
}
