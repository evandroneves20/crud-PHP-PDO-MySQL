<?php

namespace Evand\CrudPhpPdoMySql\Controller;

use Evand\CrudPhpPdoMySql\Model\Produto;
use Evand\CrudPhpPdoMySql\Util\IoFile;

class ProdutoController
{
    public function index(array $message = null)
    {
        $obj = new Produto();
        $produtos = $obj->getAll();
        include "src/View/produto/produto-lista.php";
    }

    public function create()
    {
        include "src/View/produto/produto-cadastra.php";
    }

    public function edit()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $produto = Produto::find($id);
        include "src/View/produto/produto-edita.php";
    }


    public function store()
    {
        ///validação no back
        /// //////

        $produto = new Produto();
        $produto->nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $produto->sku = filter_input(INPUT_POST, 'sku', FILTER_SANITIZE_STRING);
        $produto->valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT);
        $produto->estoque = filter_input(INPUT_POST, 'estoque', FILTER_SANITIZE_NUMBER_INT);
        $produto->foto = null;

        try {
            $result = $produto->save();
            if ($result) {
                if (isset($_FILES['inputFoto'])) {
                    $ioFile = new IoFile();
                    $extPermitidas = ["jpeg", "jpg", "png", "JPEG", "JPG", "PNG"];
                    if ($ioFile->upload($_FILES['inputFoto'], $extPermitidas, $produto->id)) {
                        $produto->foto = $ioFile->getFileLocation();
                        $produto->update();
                    }
                }
            }

            $message = ['type' => 'success', 'text' => "Produto Cadastrado com Sucesso"];
            $this->index($message);
        } catch (\Exception $ex) {
            $message = ['type' => 'danger', 'text' => "Erro ao cadastrar no banco {$ex->getMessage()}"];
            $this->index($message);
        }
    }

    public function update()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $produto = Produto::find($id);

        if ($produto) {
            $produto->nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $produto->sku = filter_input(INPUT_POST, 'sku', FILTER_SANITIZE_STRING);
            $produto->valor = floatval(filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_STRING));
            $produto->estoque = filter_input(INPUT_POST, 'estoque', FILTER_SANITIZE_NUMBER_INT);

            if (isset($_FILES['inputFoto']) && $_FILES['inputFoto']['error'] === 0) {
                $ioFile = new IoFile();
                $extPermitidas = ["jpeg", "jpg", "png", "JPEG", "JPG", "PNG"];
                if ($ioFile->upload($_FILES['inputFoto'], $extPermitidas, $produto->id)) {
                    $produto->foto = $ioFile->getFileLocation();
                }
            }

            $produto->update();
            $message = ['type' => 'success', 'text' => "Produto Atualizado com Sucesso"];
            $this->index($message);
        } else {
            $message = ['type' => 'danger', 'text' => "Produto Não localizado"];
            $this->index($message);
        }
    }

    public function delete()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $produto = Produto::find($id);

        if ($produto) {

            $img = $produto->foto;
            $produto->delete();

            $ioFile = new IoFile();
            $ioFile->deleta($img);

            $message = ['type' => 'success', 'text' => "Produto Excluído com Sucesso"];
            $this->index($message);
        } else {
            $message = ['type' => 'danger', 'text' => "Produto Não localizado"];
            $this->index($message);
        }
    }
}
