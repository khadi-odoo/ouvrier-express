<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrestationServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nomService' => 'string|min:5|max:100',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'presentation' => 'string|min:5|max:250',
            'experience' => 'string|min:5|max:250',
            'competence' => 'string|min:5|max:250',
            'motivation' => 'string|min:5|max:250',
        ];
    }
}
