<?php

namespace Modules\Utilities\Userful\Bases;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'message' => 'Dados inválidos',
            'details' => $errors->messages(),
        ], 422);
        throw new HttpResponseException($response);
    }

    public function messages()
    {
        return [
            'name.required' => $this->getTextObrigatory(),
            'password.required' => $this->getTextObrigatory(),
            'password.confirmed' => "A confirmação da :attribute não coincide.",
            'email.required' => $this->getTextObrigatory(),
            'email.email' => $this->getTextNotIsvalid(),
            'email.unique' => "O :attribute já foi usado",
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nome',
            'password' => 'Senha',
            'email' => 'Email',
        ];
    }

    /*
     * Pegar Estilos de textos
     */
    private function getTextObrigatory()
    {
        return 'O campo :attribute é obrigatorio';
    }

    private function getTextNotIsvalid()
    {
        return 'O campo :attribute não possui um :attribute válido';
    }

}
