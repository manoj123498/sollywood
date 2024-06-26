<?php

namespace App\Http\Requests\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChartPaginateRequest extends FormRequest
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
            'status'    => Rule::in(Order::STATUS),
            'perPage'   => 'integer|min:1|max:100',
            'export'    => 'string|in:excel',
            'date_from' => 'required|date_format:Y-m-d',
            'date_to'   => 'date_format:Y-m-d',
            'shop_id'   => 'exists:shops,id',
            'column'    => 'regex:/^[a-zA-Z-_]+$/',
            'sort'      => 'string|in:asc,desc',
            'search'    => 'string',
        ];
    }
}
