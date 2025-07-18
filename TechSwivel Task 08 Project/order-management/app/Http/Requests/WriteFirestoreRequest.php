<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WriteFirestoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orderId'    => 'required',
            'status'     => 'required|string|in:PENDING,ACCEPTED,PICKED,ON_MY_WAY,DELIVERED,COMPLETED',
            'riderName'  => 'required|string',
        ];
    }
}