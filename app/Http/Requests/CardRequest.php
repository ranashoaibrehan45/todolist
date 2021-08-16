<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
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
                    'title' => 'required|min:3|max:255|unique:cards',
                    'description' => 'required|min:3|max:500',
                ];
                break;
            
            case 'PUT':
                return [
                    'title' => 'required|min:3|max:255|unique:cards,title,'. $this->route('card')->id,
                    'description' => 'required|min:3|max:500',
                ];
                break;
            
            default:
                # code...
                break;
        }
    }
}
