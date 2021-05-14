<?php

class Mysql{
    private static $instance;
    private $con;
    private $host;
    private $dbname;
    private $root;
    private $pass;

    public function __construct(){
        try {
            $this->host ="127.0.0.1";
            $this->dbname = "lojamatrix";
            $this->root = "root";
            $this->pass = "";
            $this->con = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8","$this->root","$this->pass");
        }catch (Exception $e) {
            echo "Falha na tentativa de conectar ao banco! " . $e->getMessage();
        }
    }

    public static function getInstance(){
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function readQuery($query){
        if ($this->con != null){
            $sql = $this->con->prepare($query);
            $sql->execute();
            $dados = $sql->fetchAll();
        }else{
            return -1;
        }
        return $dados;
    }

    public function insertQuery($query){
        if ($this->con != null) {
            $sql = $this->con->prepare($query);
            $sql->execute();
        } else {
            return -1;
        }
        return $sql;
    }

    public function alterQuery($query){
        if ($this->con != null) {
            $sql = $this->con->prepare($query);
            $sql->execute();
        } else {
            return -1;
        }
        return $sql;
    }

    public function deleteQuery($query){
        if ($this->con != null) {
            $sql = $this->con->prepare($query);
            $sql->execute();
        } else {
            return -1;
        }
        return $sql;
    }

    public function __destruct(){
        $this->con = null;
    }
}

?>


