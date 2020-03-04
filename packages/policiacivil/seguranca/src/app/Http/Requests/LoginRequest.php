<?php

namespace PoliciaCivil\Seguranca\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PoliciaCivil\Seguranca\App\Models\Entity\Usuario;
use PoliciaCivil\Seguranca\App\Models\Regras\UsuarioRegras;

class LoginRequest extends FormRequest
{
//    public $usuario;
//
//    /**
//     * LoginRequest constructor.
//     */
//    public function __construct()
//    {
//        $this->usuario = new Usuario();
//    }

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
//            'email' => 'required|email',
//            'senha' => 'required',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $falhas = $validator->failed();

            if (!isset($falhas['email'])) { //passou na validação
                $email = mb_convert_case(request('email'), MB_CASE_LOWER, 'UTF-8');
                $usuario = Usuario::whereRaw("lower(email) = '$email'")->first();

                if ($usuario instanceof Usuario) {
                    $this->usuario = $usuario;

                    $senhaTxt = request('ab');//ab - só pra dificultar a localização da palavra senha

                    //tenta usar o novo campo senha como senha principal
                    if(!$usuario->verificarSenha($senhaTxt)) {
                        $validator->errors()->add('email', 'Senha incorreta.');
                        return;
                    }

//                    if (!isset($falhas['senha']) && request('senha') != $this->usuario->senha) {
//                        $validator->errors()->add('email', 'Senha incorreta.');
//                        return;
//                    }

                    if(!isset($falhas))

                    //verificando se o usuário pode acessar o sistema atual
                    if ($usuario->id != 1 && !$usuario->permissaoSistema()) { //sempre liberado para o usuário 1 - Administrador do sistema
                        $validator->errors()->add('email',
                            'Seu usuário não possui permissão para acessar este sistema.');
                        return;
                    }

                    //verificando se o login está expirado
                    if (UsuarioRegras::isLoginExpirado($usuario->id)) {
                        $validator->errors()->add('email', 'Login expirado, solicite a sua chefia a reativação');
                        return;
                    }

                } else {
                    $validator->errors()->add('email', 'E-mail não cadastrado no sistema.');
                }
            }
        });
    }
//
//    public function getValidatorInstance()
//    {
//        $validator = parent::getValidatorInstance();
//        $validator->after(function () use ($validator) {
//
//            // $falhas = $validator->failed();
//
//            // if (!isset($falhas['email'])) { //passou na validação
//            //     $usuario = Usuario::where('email', '=', request('email'))->first();
//
//            //     if ($usuario instanceof Usuario) {
//            //         $this->usuario = $usuario;
//
//            //         if (!isset($falhas['senha']) && request('senha') != $this->usuario->senha) {
//            //             $validator->errors()->add('email', 'Senha incorreta.');
//            //         }
//
//            //         //verificando se o usuário pode acessar o sistema atual
//            //         if ($usuario->id != 1 && !$usuario->permissaoSistema()) { //sempre liberado para o usuário 1 - Administrador do sistema
//            //             $validator->errors()->add('email', 'Seu usuário não possui permissão para acessar este sistema.');
//            //         }
//
//            //     } else {
//            //         $validator->errors()->add('email', 'E-mail não cadastrado no sistema.');
//            //     }
//            // }
//        });
//
//        return $validator;
//    }
}
