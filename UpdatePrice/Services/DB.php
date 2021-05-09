<?php

namespace Services;

use Exception;
use PDO;
use PDOException;

final class DB
{
    private $host = '127.0.0.1';
    private $dbname = 'test-boxberry';
    private $user = 'root';
    private $password = 'root';
    private $pdo;
    private static $instance;

    private function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->dbname,
                $this->user,
                $this->password
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (PDOException $e) {
            echo 'Ошибка при подключении к БД: ' . $e->getMessage();
        }

    }

    /**
     * Подготовка и выполнение запроса SQL
     * @param string $sql
     * @param array $params
     * @return array|null
     * @throws Exception
     */
    public function query(string $sql, $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);
        if (false === $result) {
            throw new Exception(implode('; ', $sth->errorInfo()));
        }
        return $sth->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Получение singleton-подключения к БД
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}