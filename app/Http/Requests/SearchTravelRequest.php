<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchTravelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from' => 'required|string',
            'to' => 'required|string',
            'travelDate' => 'required|date_format:Y-m-d|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'from.required' => 'O campo origem é obrigatório.',
            'to.required' => 'O campo destino é obrigatório.',
            'travelDate.required' => 'A data da viagem é obrigatória.',
            'travelDate.date_format' => 'A data deve estar no formato YYYY-MM-DD.',
            'travelDate.after_or_equal' => 'A data da viagem não pode ser no passado.',
        ];
    }
}