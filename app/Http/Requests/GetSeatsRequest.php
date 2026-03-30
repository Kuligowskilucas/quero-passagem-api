<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetSeatsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'travelId' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'travelId.required' => 'O ID da viagem é obrigatório.',
        ];
    }
}