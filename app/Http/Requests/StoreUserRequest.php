<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreUserRequest extends FormRequest
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
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'tel' => ['required', 'string', 'regex:/^(77|78|70|75)[0-9]{7}$/'],
            'adress' => 'required|string|max:255',
            'role' => 'required|in:client,prestataire,admin',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
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
            'nom.required' => 'Le champ nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'nom.min' => 'Le nom doit être au minimum  2 caractères.',
            'prenom.required' => 'Le champ prénom est obligatoire.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'tel.required' => 'Le champ téléphone est obligatoire.',
            'tel.string' => 'Le téléphone doit être une chaîne de caractères.',
            'tel.min' => 'Le téléphone doit comporter au moins 10 caractères.',
            'tel.regex' => 'Le téléphone doit commencer 70/77/78/76 suivis de 7 caractere',
            'tel.max' => 'Le téléphone ne peut pas dépasser 15 caractères.',
            'tel.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'role.required' => 'Le champ rôle est obligatoire.',
            'role.in' => 'Le rôle doit être soit client, soit prestataire, soit admin.',
            'email.required' => 'Le champ email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne peut pas dépasser 255 caractères.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
        ];
    }
}
