<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'nomService' => 'required|string|min:5|max:1000',
            'image' => 'image',
            'presentation' => 'required|string|min:5|max:1000',
            'experience' => 'required|string|min:5|max:1000',
            'competence' => 'required|string|min:5|max:1000',
            'motivation' => 'required|string|min:5|max:1000',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'status_code' => 422,
            'error' => true,
            'message' => 'erreur de validation',
            'errorList' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'nomService' => 'Le champ nomService est obligatoire.',
            'presentation.required' => 'Le champ presentation est obligatoire.',
            'experience.required' => 'Le champ experience obligatoire.',
            'competence.required' => 'Le champ compétence obligatoire.',
            'motivation.required' => 'Le champ motivation obligatoire.',

        ];
    }
}
