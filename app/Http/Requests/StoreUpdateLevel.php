<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUpdateLevel extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'level.unique' => 'Já existe um nível com essa descrição',
            'level.required' => 'Você precisa informar uma descrição para o nível',
            'level.min' => 'A descrição do nível precisa ter entre 3 e 30 caracteres ',
            'level.max' => 'A descrição do nível precisa ter entre 3 e 30 caracteres ',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'level' => ['unique:levels', 'required', 'min:3', 'max:30']
        ];
    }

    /**
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 400));
    }
}
