<?php

require_once __DIR__ . "/../dbhelperInterface.php";
require_once __DIR__ . "/createdb.php";

class SqliteController implements IDBHelper {
    // database connection object
    private $dbConn = null;

    // Statement being prepared or fetched
    private $stmt = null;

    public function __construct() {
    }

    public function Connect(array $creds) {
        if (!empty($this->dbConn)) {
            return;
        }
        error_log('INFO: connecting to sqlite database...');

        // db exists
        // if not, create
        $dbMissing = false;
        $createNewDB = new CreateSqliteDB(dirname($creds['DATABASE_PATH']));

        // Check whether the file exist
        if (!file_exists($creds['DATABASE_PATH'])){
            error_log('INFO: database does not exist.');

            $createNewDB->createPathToDb();

            // make a note to create the database later
            $dbMissing = true;
        }

        try{
            $this->dbConn = new PDO('sqlite:'. $creds['DATABASE_PATH']);

            $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbConn->setAttribute(PDO::ATTR_TIMEOUT, 5);

            // if the database does not exist, try to create it.
            if($dbMissing){
                $create = $createNewDB->New($this->dbConn);
                if($create === false) { die(); }
            }
            // // If the database already exists, but it's out of date, kill any active sessions.
            // else if ($this->getDbSchemaNumber() < $this->getAppSchemaNumber()){
            //     $this->invalidateSessions();
            // }

            // Enable foreign key constraints
            $this->dbConn->exec('PRAGMA foreign_keys = ON;');
            $this->dbConn->exec('PRAGMA temp_store = MEMORY;');
        }
        catch(PDOException $e){
            echo "Unable to connect.<br />Error: " .  $e->getMessage() . "<br />";
            error_log("Unable to connect to database. Error: " . $e->getMessage());
            die();
        }

        $lastErr = [null, null, null];
    }

    public function PrepareAndExecute(string $sql, array $params) {
        $ret = [];

        if (!empty($this->Prepare($sql))) {
            $ret = $this->Execute($this->stmt, $params);
        }

        return $ret;
    }

    public function Prepare(string $sql) {
        // clean up last query
        $this->stmt = null;

        try{
            $this->stmt = $this->dbConn->prepare($sql);
        }
        catch(PDOException $e){
            $lastErr = $e->getMessage();
            error_log(print_r($lastErr, true));

            return $this->stmt;
        }

        // breaks encapsulation,
        // but required to run Execute on the same prepared statement
        return $this->stmt;
    }

    public function Execute(PDOStatement $stmt, array $params) {
        $results = false;

        if (!is_null($stmt) && $stmt !== FALSE){
            try{
                if ($stmt->execute($params) !== FALSE) {
                    $results = [];
                    // PDOStatement::rowCount() doesn't work
                    // for SELECT in SQLite and will return 0
                    $rowCount = $stmt->rowCount();

                    // Scrolling cursors are not supported in SQLite
                    while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== FALSE){
                        // Increment the rowCount for SELECTs
                        $rowCount++;

                        $results[] = $row;
                    }
                }
            }
            catch(PDOException $e){
                $lastErr = $e->errorInfo;
                if (empty($results)){
                    error_log(print_r($e->getMessage(), true));
                    $lastErr = $e->getMessage();
                }
            }
        }

        return $results;
    }

    public function BeginTransaction() {
        return $this->dbConn->beginTransaction();
    }

    public function RollBackTransaction() {
        return $this->dbConn->rollBack();
    }

    public function CommitTransaction() {
        return $this->dbConn->commit();
    }

    // SQLite specific
    // 
    // Not reliable for MSSQL
    public function LastInsertId() {
        return $this->dbConn->lastInsertId();
    }
}