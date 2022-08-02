<?php 

  class Db{
    private $server = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "lsu";
    // private $dbname = "lsuhostels";
    
    protected function connect(){
      $dsn = "mysql:host=" .$this->server. ";dbname=" .$this->dbname;
      $pdo = new PDO($dsn, $this->user, $this->password);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      return $pdo;
    }
  }