<?php
namespace PoliciaCivil\Seguranca\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PoliciaCivil\Seguranca\App\Models\Entity\Usuario;

class UsuarioRequest extends FormRequest
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
            'nome' => 'required',
//            'email' => 'required|email|unique:seguranca.usuario,email',
            'email' => 'required|email',
            'senha' => 'nullable|min:8|confirmed',
            'dt_nascimento' => 'nullable|date_format:d/m/Y|nullable|before:tomorrow',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Digite um e-mail válido',
            'senha.min' => 'A senha deve ter no mínimo 8 caracteres',
            'dt_nascimento.before' => 'Data de nascimento não pode ser uma data no futuro',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $falhas = $validator->failed();

            //se houver qualquer erro na validação básica, então retorna os erros
            if (!empty($falhas)) {
                return;
            }

            $edicao = request('id', null) != null ? true : false;

            //verificando se o usuário já está cadastrado no banco de dados
            if (!$edicao) {
                $usuario = Usuario::select('id')
                    ->where('email', '=', request('email'));

                if ($usuario->count()) {
                    $validator->errors()->add('email', 'Este email já está em uso por outro usuário.');
                }

                if (!request('senha', null)) {
                    $validator->errors()->add('senha', 'Digite uma senha para o usuário.');
                }
            }
        });
        return $validator;
    }
}
