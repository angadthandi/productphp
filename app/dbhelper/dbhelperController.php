<?php

require_once __DIR__ . "/dbhelperInterface.php";

class DBHelperController {
    private $dbType;

    public function __construct(IDBHelper $db) {
        $this->dbType = $db;
    }

    public function Connect(array $creds) {
        $this->dbType->Connect($creds);
    }

    public function PrepareAndExecute(string $query, array $params) {
        return $this->dbType->PrepareAndExecute($query, $params);
    }

    public function Prepare(string $query) {
        return $this->dbType->Prepare($query);
    }

    public function Execute(PDOStatement $stmt, array $params) {
        return $this->dbType->Execute($stmt, $params);
    }

    public function BeginTransaction() {
        return $this->dbType->BeginTransaction();
    }

    public function RollBackTransaction() {
        return $this->dbType->RollBackTransaction();
    }

    public function CommitTransaction() {
        return $this->dbType->CommitTransaction();
    }

    public function LastInsertId() {
        return $this->dbType->LastInsertId();
    }
}