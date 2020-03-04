<?php

namespace PoliciaCivil\Seguranca\App\Requests;

use PoliciaCivil\Seguranca\App\Models\Entity\SegMenu;
use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'dica' => 'required',
            'acao' => 'required',
            'ordem' => 'required',
        ];
    }

    public function getValidatorInstance() {
        $validator = parent::getValidatorInstance();
        $validator->after(function() use ($validator) {

            $falhas = $validator->failed();

            //se houver qualquer erro na validação básica, então retorna os erros
            if(!empty($falhas)) return;

            $edicao = request('menu', null) != null ? true : false;

            //verificando se o menu já está cadastrado no banco de dados
            if(!$edicao) {
                $menu = SegMenu::select('id')
                        ->where('nome', request('nome'))
                        ->where('acao_id', request('acao'));

                if(request('pai', null) != null)
                    $menu->where('pai', request('pai'));

                if($menu->count()) {
                    $validator->errors ()->add('nome', 'Este menu já está cadastrado no banco de dados.');
                }
            }
        });
        return $validator;
    }
}
