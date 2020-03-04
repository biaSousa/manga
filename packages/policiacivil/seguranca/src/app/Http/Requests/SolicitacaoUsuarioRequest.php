<?php

namespace PoliciaCivil\Seguranca\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PoliciaCivil\Seguranca\App\Models\Entity\Usuario;

class SolicitacaoUsuarioRequest extends FormRequest
{

    protected $redirect = 'cadastro/passo2';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'email' => 'required|email',
            'cpf' => 'required',
            'nascimento' => 'required|date_format:d/m/Y|before:tomorrow',
            'unidade' => 'required',
            'senha' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'nascimento.before' => 'Data de nascimento não pode ser uma data no futuro',
            'senha.confirmed' => 'As senhas digitadas não estão iguais'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return \Illuminate\Validation\Validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $falhas = $validator->failed();

            //se houver qualquer erro na validação básica, então retorna os erros
            if (!empty($falhas)) {
                return;
            }

            $email = request('email');
            $cpf = request('cpf');

            $usuario = Usuario::where('email', $email)
                ->orWhere('cpf', $cpf)
                ->first();

            if ($usuario) { //já existe um cadastro para este usuário

                if ($email === $usuario->email) {
                    $validator->errors()->add('email', 'Email já cadastrado no sistema.');

                } else {
                    if ($cpf === $usuario->cpf) {
                        $validator->errors()->add('cpf', 'CPF já cadastrado no sistema.');
                    }
                }
            }

        });

        return $validator;
    }
}
