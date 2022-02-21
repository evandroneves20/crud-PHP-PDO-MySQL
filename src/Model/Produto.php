<?php

namespace Evand\CrudPhpPdoMySql\Model;

use Evand\CrudPhpPdoMySql\Repository\Database;

class Produto
{
    protected $values = [];

    public function __set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public static function find(int $id)
    {
        $db = new Database();
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $params = [':id' => $id];
        return $db->findDB($sql, $params, new Produto());
    }

    public function __get($key)
    {
        return $this->values[$key];
    }

    public function getAll()
    {
        $db = new Database();
        $sql = "SELECT * FROM produtos";

        $result = $db->selectDB($sql);

        return $result;
    }

    public function save()
    {
        $db = new Database();
        $sql = "INSERT INTO produtos (nome, sku, foto, valor, estoque) VALUE (?,?,?,?,?)";
        $params = [$this->nome, $this->sku, $this->foto, $this->valor, $this->estoque];

        $id = $db->insertDB($sql, $params);

        if ($id) {
            $this->id = $id;
            return true;
        }

        return false;
    }

    public function update()
    {
        $db = new Database();

        $sql = "UPDATE produtos SET nome = :nome, sku = :sku, foto = :foto, valor = :valor, estoque = :estoque WHERE id = :id";
        $params = [
            'nome' => $this->nome,
            'sku' => $this->sku,
            'foto' => $this->foto,
            'valor' => (string)$this->valor,
            'estoque' => $this->estoque,
            'id' => $this->id
        ];

        return $db->updateDB($sql, $params);
    }

    public function delete()
    {
        $db = new Database();
        $sql = "DELETE FROM produtos WHERE id = :id";
        $params = ['id' => $this->id];

        return $db->deleteDB($sql, $params);
    }
}
