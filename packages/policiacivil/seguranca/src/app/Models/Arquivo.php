<?php

namespace PoliciaCivil\Seguranca\App\Models;

class Arquivo
{
    private $conteudo = null;

    public function __construct($endereco_arquivo)
    {
        $this->conteudo = explode(PHP_EOL, file_get_contents($endereco_arquivo));
    }

    /**
     * Retorna o índice do array que contém o elemento pesquisado
     */
    public function pesquisar($textoRegex)
    {
        if (!$this->conteudo) {
            return null;
        }

        $local = null;
        foreach ($this->conteudo as $linha => $a) {
            if (preg_match("/$textoRegex/", $a)) { //entrou no array aliases
                $local = $linha;
                break;
            }
        }
        return $local;
    }

    public function grudarAntes($indice, array $linhas): array
    {
        return $this->inserir($indice, $linhas, 'antes');
    }

    public function grudarDepois($indice, array $linhas): array
    {
        return $this->inserir($indice, $linhas, 'depois');
    }

    public function inserir($indice, $linhas, $posicao): array
    {
        $aNovoArray = [];
        foreach ($this->conteudo as $k => $v) {
            if ($k == $indice) {

                if ($posicao === 'antes') {
                    //incluindo linhas no array
                    foreach ($linhas as $novaLinha) {
                        $aNovoArray[] = $novaLinha;
                    }
                    $aNovoArray[] = $v;
                }

                if ($posicao === 'depois') {
                    $aNovoArray[] = $v;
                    foreach ($linhas as $novaLinha) {
                        $aNovoArray[] = $novaLinha;
                    }
                }
            } else {
                $aNovoArray[] = $v;
            }
        }
        $this->conteudo = $aNovoArray;
        return $aNovoArray;
    }

    /**
     * Transforma todas as linhas de um arquivo em itens de um array
     *
     * @param string $arquivo
     * @return void
     */
    public static function toArray($arquivo)
    {
        return explode(PHP_EOL, file_get_contents($arquivo));
    }

    /**
     * Copia todos os arquivos de um diretório recursivamente para outro local
     *
     * @param string $src
     * @param string $dst
     * @return void
     */
    public static function copy_dir($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    copy_dir($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /**
     * Cria um arquivo recebendo um array como conteúdo
     *
     * @param string $nome
     * @param array $conteudo
     * @return void
     */
    public static function criarArquivo($nome, array $conteudo)
    {
        $conteudo = implode(PHP_EOL, $conteudo);
        file_put_contents($nome, $conteudo);
    }
}
