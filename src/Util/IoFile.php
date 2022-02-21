<?php

namespace Evand\CrudPhpPdoMySql\Util;

class IoFile
{
    private $file;
    private $pastadestino = "public/img/produtos/";
    private $extPermitidas;
    private $nomefinal;
    private $renomeia = TRUE;

    public function setRenomeia($renomeia)
    {
        $this->renomeia = $renomeia;
    }

    public function getPastaArquivos()
    {
        return $this->pastadestino;
    }

    public function deleta($img)
    {
        unlink($img);
    }

    public function getFileLocation()
    {
        return $this->pastadestino . $this->nomefinal;
    }

    public function upload($__FILE, array $extPermitidas, $nome, $pasta_destino = NULL)
    {
        $this->file = $__FILE;

        try {
            if (!file_exists($this->pastadestino)) {
                if (!$this->criaPasta($this->pastadestino)) {
                    throw new \Exception("Não foi possível criar a pasta;");
                }
            }
            $this->extPermitidas = $extPermitidas;

            $_UP["renomeia"] = false;

            $_UP['erros'][0] = "Não houve erro";
            $_UP['erros'][1] = "Tamanho do arquivo superior ao limite permitido";
            $_UP['erros'][2] = "O arquivo ultrapassa o limite de tamanho especificado no html";
            $_UP['erros'][3] = "O upload do arquivo foi feito parcialmente";
            $_UP['erros'][4] = "Não foi feito o upload do arquivo";

            if ($this->file['error'] != 0) {
                throw new \Exception("Não foi possível fazer o upload do arquivo, erro:<br/>" . $_UP['erros'][$this->file[$this->input]["error"]]);
            }

            $extensao = explode(".", $this->file['name']);
            if (array_search(end($extensao), $this->extPermitidas) === false) {
                throw new \Exception("Por favor, envie os arquivos com as seguintes extensões: " . $this->extPermitidas);
            }

            $nome_final = $nome . "." . end($extensao);

            move_uploaded_file($this->file['tmp_name'], $this->pastadestino . $nome_final);
            $this->nomefinal = $nome_final;
            return true;
        } catch (\Exception $e) {

            return false;
        }
    }

    private function criaPasta($pastadestino)
    {
        return mkdir($pastadestino, 0755, TRUE);
    }

    public function getPastadestino()
    {
        return $this->pastadestino;
    }

    public function getExtPermitidas()
    {
        return $this->extPermitidas;
    }

    public function getNomefinal()
    {
        return $this->nomefinal;
    }
}
