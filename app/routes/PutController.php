<?php

require_once __DIR__ . "/routesInterface.php";

class PutController implements IRoutes {
    public function __construct() {
        
    }

    public static function Type() {
        return 'PUT';
    }

    public function Handle(DBHelperController $db, array $data) {
        $ret = [];

        return $ret;
    }
}