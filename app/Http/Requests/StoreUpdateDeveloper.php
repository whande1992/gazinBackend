<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUpdateDeveloper extends FormRequest
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

    public function messages(): array
    {
        return [
            "level_id.required" => "Você precisa informar um nível para o desenvolvedor",
            "level_id.integer" => "Você precisa informar um ID de nível",
            "level_id.exists" => "Nível informado não existe, você precisa cadastrar primeiro.",
            "name.required" => "Você precisa informar um nome para o desenvolvedor",
            "name.string" => "Você precisa informar um nome válido para o desenvolvedor",
            "name.unique" => "Ops, parece que esse desenvolvedor já esta cadastrado",
            "name.min" => "O nome deve ter entre 3 e 70 caracteres",
            "gender.required" => "Você precisa o sexo do desenvolvedor:  'F' para Feminino ou 'M' para Masculino ",
            "gender.string" => "Você precisa informar um sexo válido: 'F' para Feminino ou 'M' para Masculino ",
            "gender.in" => "Você precisa enviar 'F' para Feminino ou 'M' para Masculino ",
            "birth_date.required" => "Você precisa enviar a data de nascimento. ",
            "birth_date.date" => "Você precisa enviar a data de nascimento no formado 'AAAA-MM-DD' ",
            "hobby.string" => "Ahh!!!, eu sei que você faz alguma coisa legal, me conta ai vai, pode ser qualquer coisa :D" ,
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
            "level_id" => ["required", "integer", "exists:levels,id"],
            "name"     => ["required", "string", "unique:developers,name,{$this->route('developer')}", "min:3", "max:70"],
            "gender"   => ["required", "string", "in:F,M"],
            "birth_date" => ["required", "date", "date_format:Y-m-d"],
            "hobby"     => ["string"]
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
