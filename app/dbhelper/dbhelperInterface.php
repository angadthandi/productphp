<?php

interface IDBHelper {
    public function Connect(array $creds);
    public function PrepareAndExecute(string $sql, array $params);
    public function Prepare(string $sql);
    public function Execute(PDOStatement $stmt, array $params);
    public function BeginTransaction();
    public function RollBackTransaction();
    public function CommitTransaction();
}