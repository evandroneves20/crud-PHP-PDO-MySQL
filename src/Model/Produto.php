<?php

namespace Evand\CrudPhpPdoMySql\Model;

use Evand\CrudPhpPdoMySql\Repository\Database;

class Produto
{
    private $nome;
    private $sku;
    private $foto;
    private $preco;
    private $estoque;

    private $table = 'produtos';

    public function __set($name, $value)
    {
        $this->name = $value;
    }

    public function __get($name)
    {
        return $this->name;
    }

    public function getAll()
    {

    }

    public function save()
    {
        $db = new Database();
        $sql = "INSERT INTO {$this->table} (nome, sku, foto, preco, estoque) VALUE (?,?,?,?,?)";
        $params = [$this->nome, $this->sku, $this->foto, $this->preco, $this->estoque];

        return $db->insertDB($sql, $params);
    }

    public function update()
    {
        $db = new Database();

        $sql = "UPDATE {$this->table} SET nome = :nome, sku = :sku, foto= :foto, preco = :preco, estoque = :estoque WHERE id = :id";
        $params = [':nome' => $this->nome, ':sku' => $this->sku, ':foto' => $this->foto, ':preco' => $this->preco, ':estoque' => $this->estoque, ':id' => $this->id];

        return $db->updateDB($sql, $params);
    }

    public function delete()
    {
        $db = new Database();
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $params = [':id' => $this->id];

        return $db->deleteDB($sql, $params);
    }
}
