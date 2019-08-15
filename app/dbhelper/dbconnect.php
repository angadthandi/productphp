<?php

require_once __DIR__ . "/dbhelperController.php";
require_once __DIR__ . "/sqlite/sqliteController.php";

function dbConnect() {
    static $db;

    if (empty($db)) {
        $conf = ['DATABASE_PATH' => '../../db/productdb.db'];

        $db = new DBHelperController(new SqliteController);
        $db->Connect($conf);
    }

    return $db;
}