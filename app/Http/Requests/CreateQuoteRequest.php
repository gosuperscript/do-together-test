<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'accountId' => 'required|uuid',
            'productId' => 'required|uuid',
            'dateStart' => 'required|date',
            'covers' => 'required|array',
            'covers.*.coverId' => 'required|uuid',
            'covers.*.limit' => 'required|int',
            'covers.*.excess' => 'required|int',
            'covers.*.is_made_of_mostly_wood' => 'required_if:covers.*.coverId,7b573a7e-d40a-4a3a-9414-c646e9b27590|bool',
            'covers.*.postcode' => 'required_if:covers.*.coverId,27009da6-c984-4e2c-8e9e-045adf958593|int',
        ];
    }
}
