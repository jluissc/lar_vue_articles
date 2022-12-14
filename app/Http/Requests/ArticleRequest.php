<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
        return [
            'name' => 'required|min:4|max:80',
            'description' => 'required|min:5', 
            'stock' => 'required|integer', 
        ];
    }

    public function messages()
    {
        return [
            'name.*' => 'Erro min',
            'description.*' => 'erro max', 
            'stock.*' => 'solo number', 
        ];
    }
}
