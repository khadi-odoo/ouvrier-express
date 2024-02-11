<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrestationServiceRequest extends FormRequest
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
            'nomService' => 'required|string|min:5|max:100',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'presentation' => 'required|string|min:5|max:250',
            'experience' => 'required|string|min:5|max:250',
            'competence' => 'required|string|min:5|max:250',
            'motivation' => 'required|string|min:5|max:250',
        ];
    }
}
