<?php

namespace PoliciaCivil\Seguranca\App\Http\Requests;

use PoliciaCivil\Seguranca\App\Models\Entity\SegAcao;
use Illuminate\Foundation\Http\FormRequest;

class AcaoRequest extends FormRequest
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

    public function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        $validator->after(function () use ($validator) {

            $falhas = $validator->failed();

            //se houver qualquer erro na validação básica, então retorna os erros
            if (!empty($falhas)) return;

            $edicao = request('id', null) != null ? true : false;

            if (!$edicao) {
                //verificando se a ação já está cadastrada no banco de dados
                $acao = SegAcao::select('id')->where('nome', request('nome'))->count();
                if ($acao) {
                    $validator->errors()->add('nome', 'Esta ação já está cadastrada no banco de dados.');
                }
            }

            if (request('destaque') == 'on' && !request('nome_amigavel', null)) {
                $validator->errors()->add('nome_amigavel', 'Nome amigável não informado');
            }
        });
        return $validator;
    }
}
