<?php

namespace PoliciaCivil\Seguranca\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtualizarDadosRequest extends FormRequest
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
            'cpf' => 'required',
            'nascimento' => 'required|date_format:d/m/Y|before:tomorrow',
        ];
    }

    public function messages()
    {
        return [
            //formato de data
            'nascimento.date_format' => 'Digite uma data válida no campo nascimento',
            //datas no futuro
            'nascimento.before' => 'Data de nascimento não pode ser uma data no futuro',
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

            if (!$this->validarCPF(request('cpf', null))) {
                $validator->errors()->add('cpf', 'Digite um cpf válido.');
            }
        });
    }

    public function validarCPF($cpf)
    {
        $nulos = array("12345678909", "11111111111", "22222222222", "33333333333",
            "44444444444", "55555555555", "66666666666", "77777777777",
            "88888888888", "99999999999", "00000000000");

        /* Retira todos os caracteres que nao sejam 0-9 */
        $cpf = preg_replace("/[^0-9]/", "", $cpf);

        /* Retorna falso se houver letras no cpf */
        if (!preg_match("/[0-9]{8}/", $cpf)) {
            return false;
        }

        /* Retorna falso se o cpf for nulo */
        if (in_array($cpf, $nulos)) {
            return false;
        }

        /* Calcula o penúltimo dígito verificador */
        $acum = 0;
        for ($i = 0; $i < 9; $i++) {
            $acum += $cpf[$i] * (10 - $i);
        }

        $x = $acum % 11;
        $acum = ($x > 1) ? (11 - $x) : 0;
        /* Retorna falso se o digito calculado eh diferente do passado na string */
        if ($acum != $cpf[9]) {
            return false;
        }
        /* Calcula o último dígito verificador */
        $acum = 0;
        for ($i = 0; $i < 10; $i++) {
            $acum += $cpf[$i] * (11 - $i);
        }

        $x = $acum % 11;
        $acum = ($x > 1) ? (11 - $x) : 0;
        /* Retorna falso se o digito calculado eh diferente do passado na string */
        if ($acum != $cpf[10]) {
            return false;
        }
        /* Retorna verdadeiro se o cpf eh valido */
        return true;
    }
}
