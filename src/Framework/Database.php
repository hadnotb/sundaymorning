<?php 

namespace App\Framework;

use \PDO;
use \PDOStatement;

class Database {

    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getPdoConnection();
    }

    function getPdoConnection(): PDO
    {
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=UTF8';

        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);

        return $pdo;
    }

    function executeQuery(string $sql, array $params = []): PDOStatement
    {
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute($params);

        return $pdoStatement;
    }

    function getOneResult(string $sql, array $params = [])
    {
        $pdoStatement = $this->executeQuery($sql, $params);
        $result = $pdoStatement->fetch();

        return $result;
    }

    function getAllResults(string $sql, array $params = [])
    {
        $pdoStatement = $this->executeQuery($sql, $params);
        $results = $pdoStatement->fetchAll();

        return $results;
    }

    function insert(string $sql, array $params = [])
    {
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute($params);
        return $this->pdo->lastInsertId();
    }

    function getResults(string $sql, array $params = [])
    {
        $pdoStatement = $this->executeQuery($sql, $params);
        $results = $pdoStatement->fetchAll();

        return $results;
    }

}