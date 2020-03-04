<?php

namespace PoliciaCivil\Seguranca\App\Requests;

use PoliciaCivil\Seguranca\App\Models\Entity\SegPerfil;
use Illuminate\Foundation\Http\FormRequest;

class PerfilRequest extends FormRequest
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
        $validator->after(function ($validator)  {
//        $validator->errors ()->add('nome', 'Este perfil já está cadastrado no banco de dados.');

            $falhas = $validator->failed();

            //se houver qualquer erro na validação básica, então retorna os erros
            if(!empty($falhas)) return;

            $edicao = request('perfil', null) != null ? true : false;

            //verificando se o menu já está cadastrado no banco de dados
            if(!$edicao) {
                $menu = SegPerfil::select('id')
                    ->where('nome', '=', request('nome'));

                if($menu->count()) {
                    $validator->errors ()->add('nome', 'Este perfil já está cadastrado no banco de dados.');
                }
            } else {
                if(!request('perfil', null)) {
                    $validator->errors ()->add('perfil', 'Código do perfil não encontrado no fomulário.');
                }
            }
        });
    }

//    public function getValidatorInstance() {
//        $validator = parent::getValidatorInstance();
//        $validator->after(function() use ($validator) {
//
//            $falhas = $validator->failed();
//
//            //se houver qualquer erro na validação básica, então retorna os erros
//            if(!empty($falhas)) return;
//
//            $edicao = request('perfil', null) != null ? true : false;
//
//            //verificando se o menu já está cadastrado no banco de dados
//            if(!$edicao) {
//                $menu = SegPerfil::select('id')
//                    ->where('nome', '=', request('nome'));
//
//                if($menu->count()) {
//                    $validator->errors ()->add('nome', 'Este perfil já está cadastrado no banco de dados.');
//                }
//            } else {
//                if(!request('perfil', null)) {
//                    $validator->errors ()->add('perfil', 'Código do perfil não encontrado no fomulário.');
//                }
//            }
//        });
//        return $validator;
//    }
}
