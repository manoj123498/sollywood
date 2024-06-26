<?php

namespace App\Http\Requests\Admin\ShopTag;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title'                 => 'required|array',
            'title.*'               => 'string|min:1|max:255',
            'images'                => 'array',
            'images.*'              => 'string|min:1|max:255',
        ];
    }
}
