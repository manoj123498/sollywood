<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StripeRequest extends FormRequest
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
        $userId = null;

        if (!auth('sanctum')?->user()?->hasRole('admin')) {
            $userId = auth('sanctum')->id();
        }

        return [
            'order_id'  => [
                'required',
                Rule::exists('orders', 'id')
                    ->whereNull('deleted_at')
                    ->when(!empty($userId), fn($q) => $q->where('user_id', $userId))
            ],
        ];
    }
}
