<?php

require_once __DIR__ . "/routesInterface.php";
require_once __DIR__ . "/../dbhelper/dbconnect.php";

class RoutesController {
    private $routeType;
    private $dbConn;

    public function __construct(IRoutes $route) {
        $this->routeType = $route;

        // connect to database
        $this->dbConn = dbConnect();
    }

    public function Handle(array $data) {
        $action = (isset($data['action'])) ? $data['action'] : null;

        if (empty($action)) {
            error_log('Invalid request: undefined action!');
            return ['error'=>'Invalid request: undefined action!'];
        }

        return $this->routeType->Handle($this->dbConn, $data);
    }
}