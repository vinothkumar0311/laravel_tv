<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subscription_plan_id' => 'required|integer|exists:subscription_plans,id',
            'payment_id' => 'nullable|string|max:255',
            'method' => 'nullable|string|max:100',
        ];
    }
}
