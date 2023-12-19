<?php

namespace App;

use App\DB\DBConnection;
use PDO;
use Utils\Files;

class Model
{
    /**
     * Pdo singleton instance
     * 
     * @var PDO $pdo
     */
    protected $pdo;

    /**
     * Toggles debug to query execution
     * 
     * @var boolean
     */
    protected bool $debug = false;

    /**
     * Pdo Statement
     *
     * @var PDOStatement|false 
     */
    private $pdoStmt;

    protected function __construct()
    {
        $this->pdo = DBConnection::connect();
    }

    /**
     * Set debug to query execution
     *
     * @param bool $debug Toggle debug to query execution
     * @return self
     */
    protected function setDebug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * Executes a query
     * 
     * @param string $sql
     * @param array $params
     * @param bool $strictTypes
     * @return self
     * @throws PDOException
     */
    protected function runQuery(string $sql, array $params = [], bool $strictTypes = false): self
    {
        if ($this->debug) {
            echo "runQuery args: \n";
            print_r([
                "sql"         => $sql,
                "params"      => $params,
                "strictTypes" => $strictTypes
            ]);
            echo "\n\n";
        }

        try {
            $this->pdo ??= DBConnection::connect();
            $this->pdoStmt = $this->pdo->prepare($sql);
            $this->bind($params, $strictTypes);
            $this->pdoStmt->execute();
            return $this;
        } catch (\PDOException $th) {
            Files::logDbQuery($sql, $params, $strictTypes, $th->getMessage());
            throw $th;
        }
    }

    /**
     * @param array $params
     * @param boolean $strictTypes
     * @return void
     */
    private function bind(array $params, bool $strictTypes)
    {
        if ($params !== []) {
            foreach ($params as $param => $value) {
                if ($strictTypes) {
                    $type = null;
                    switch (gettype($value)) {
                        case "boolean":
                            $type = PDO::PARAM_BOOL;
                            break;
                        case "integer":
                            $type = PDO::PARAM_INT;
                            break;
                        case "NULL":
                            $type = PDO::PARAM_NULL;
                            break;
                        case "string":
                            $type = PDO::PARAM_STR;
                            break;
                    }
                    $type !== null ? $this->pdoStmt->bindValue($param, $value, $type) : $this->pdoStmt->bindValue($param, $value);
                } else {
                    $this->pdoStmt->bindValue($param, $value);
                }
            }
        }
    }

    protected function getArray()
    {
        return $this->pdoStmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function getObject()
    {
        return $this->pdoStmt->fetch(PDO::FETCH_OBJ);
    }

    protected function getColumn()
    {
        return $this->pdoStmt->fetch(PDO::FETCH_COLUMN);
    }

    protected function getAllArray()
    {
        return $this->pdoStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function getAllObject()
    {
        return $this->pdoStmt->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getAllColumn()
    {
        return $this->pdoStmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * @return string|false
     */
    protected function getLastId()
    {
        return $this->pdo->lastInsertId();
    }

    protected function getRows(): int
    {
        return $this->pdoStmt->rowCount();
    }
}
