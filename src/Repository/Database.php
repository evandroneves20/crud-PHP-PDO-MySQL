<?php

namespace Evand\CrudPhpPdoMySql\Repository;

class Database
{
    private $type = "mysql";
    private $host = "localhost";
    private $port = "3306";
    private $user = "root";
    private $db = "crud_php";
    private $password = "tt333";

    private $conexao;

    public function conecta()
    {
        try {
            $this->conexao = new \PDO("{$this->type}:host={$this->host};port={$this->port};dbname={$this->db}",
                $this->user, $this->password);
        } catch (\PDOException $ex) {
            die("Erro ao conectar ao banco de dados <code>{$ex->getMessage()}</code>");
        }

        return $this->conexao;
    }

    public function __destruct()
    {
        $this->disconecta();
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    public function disconecta()
    {
        $this->conexao = null;
    }

    public function insertDB($sql, $params = null)
    {
        $conexao = $this->conecta();
        $query = $conexao->prepare($sql);
        $query->execute($params);

        $result = $conexao->lastInsertId();

        if (!$result) {
            throw new \Exception("Erro ao Cadastrar o Registro <br>{$query->errorInfo()}");
        }

        $this->__destruct();

        return $result;
    }

    public function updateDB($sql, $params)
    {
        $query = $this->conecta()->prepare($sql);
        $query->execute($params);
        $result = $query->rowCount();

//        if (!$result) {
//            throw new \Exception("Erro ao Atualizar o Registro <br>{$query->errorInfo()}");
//        }

        $this->__destruct();
        return $result;
    }

    public function deleteDB($sql, $params = null)
    {
        $query = $this->conecta()->prepare($sql);
        $query->execute($params);
        $result = $query->rowCount();

        if (!$result) {
            throw new \Exception("Erro ao Excluir o Registro <br>{$query->errorInfo()}");
        }

        $this->__destruct();
        return $result;
    }

    public function selectDB($sql, $params = null)
    {
        $query = $this->conecta()->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(\PDO::FETCH_OBJ) or die(print_r($query->errorInfo(), true));

        $this->__destruct();
        return $result;
    }

    public function findDB($sql, $params, $object){
        $query = $this->conecta()->prepare($sql);
        $query->execute($params);

        return $query->fetchObject(get_class($object));
    }
}
