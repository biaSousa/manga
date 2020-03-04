<?php

namespace PoliciaCivil\Seguranca\App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    private $_log = true; //o padrão é gerar log a menos que o contrário seja dito aqui desabilitarLog();

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        //desabilita o log para ambientes de teste, isto permite gerar teste de carga sem erro da casse Historico
        if ($_ENV['APP_ENV'] === 'test') {
            $this->desabilitarLog();
        }
    }

    /**
     * Sobrescreve a ação de salvar do laravel para criação de logs de forma transparente ao desenvolvedor
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if ($this->_log) {
            if ($this->exists) { //se existir é um update
                $this->registrarLog('U');
            } else { //é um insert
                $this->registrarLog('I');
            }

            if (!DB::$TRANSACTION) //se não houver uma trasação, então cria o log
            {
                DB::criarLog();
            }

        }
        return parent::save();
    }

    public function registrarLog($acao)
    {
        $oHistorico = Historico::getInstance();

        if ($acao == 'I') {
            $atributos = $this->attributes; //todos os atributos da classe e seus valores
            if (!empty($this->casts) && in_array('array',
                    $this->casts)) { //se na classe há conversão de json para array em algum campo
                foreach ($this->casts as $k => $cast) {
                    /*
                     * decode uma string json em array. Ela será reconvertida pela classe histórico como
                     * um json válido e não como um json escapado
                     */
                    $atributos[$k] = json_decode($this->attributes[$k]);
                }
            }

            $oHistorico->insert(
                $this->table,
                $atributos
            );
        } else {
            if ($acao == 'U') {

                //obtendo nome da subclasse que chamou esta superclasse
                $class = get_called_class();

                //obtendo os dados atuais antes do usuário atualizá-las
                $c = $class::find($this->attributes[$this->primaryKey]);

                $oHistorico->update(
                    $this->table,
                    $c->attributes,
                    $this->attributes,
                    "{$this->primaryKey} = {$c->{$this->primaryKey}}"
                );
            } else {
                if ($acao == 'D') {
                    $atributos = $this->attributes; //todos os atributos da classe e seus valores
                    if (!empty($this->casts) && in_array('array',
                            $this->casts)) { //se na classe há conversão de json para array em algum campo
                        foreach ($this->casts as $k => $cast) {
                            /*
                             * decode uma string json em array. Ela será reconvertida pela classe histórico como
                             * um json válido e não como um json escapado
                             */
                            $atributos[$k] = json_decode($this->attributes[$k]);
                        }
                    }

                    $oHistorico->delete(
                        $this->table,
                        $atributos
                    );
                }
            }
        }
    }

    /**
     * Sobrescreve a ação de deletar do laravel para criação de logs de forma transparente ao desenvolvedor
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        if ($this->_log) {
            $this->registrarLog('D');
        }
        return parent::delete();
    }

    /**
     * Desabilita log. A ideia é que seja usado apenas na parte pública de um sistema pois, teoricamente, o usuário
     * não estará logado e não será possível saber quem fez a modificação na tabela.
     * Este método deve ser chamdo antes de chamar save() ou delete()/destroy() em um objeto
     */
    public function desabilitarLog()
    {
        $this->_log = false;
    }

    /**
     * Habilita log. Deve ser chamado apenas se o desabilita foi usado alguma vez, pois o padrão é gerar log sempre
     * Este método deve ser chamdo antes de chamar save() ou delete()/destroy() em um objeto
     */
    public function habilitarLog()
    {
        $this->_log = true;
    }
}
