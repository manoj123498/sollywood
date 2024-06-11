<?php

namespace App\Http\Requests;

use App\Models\Birthday;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BirthdayEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gift_amount' => ['string'],
        ];
    }

}
