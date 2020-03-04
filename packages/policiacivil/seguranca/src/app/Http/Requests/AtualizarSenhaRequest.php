<?php

namespace App\Seguranca\Requests;

use App\Http\Requests\Request;

class AtualizarSenhaRequest extends Request
{
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
            'antiga' => 'required|min:8',
            'senha' => 'required|min:8|confirmed'
        ];
    }

    public function getValidatorInstance() {
        $validator = parent::getValidatorInstance();
        $validator->after(function() use ($validator) {

            $falhas = $validator->failed();

            //se houver qualquer erro na validação básica, então retorna os erros
            if(!empty($falhas)) return;

            //verificando se o menu já está cadastrado no banco de dados
            $usuario = Usuario::select('id')
                ->where('email', '=', request('email'));

            if($usuario->count()) {
                $validator->errors ()->add('nome', 'Este usuário já está cadastrado no banco de dados.');
            }


        });
        return $validator;
    }
}
