<?php

require_once __DIR__ . "/orderModel.php";

class OrderController {
    private $db;
    private $orderModel;

    public function __construct(DBHelperController $db) {
        $this->db = $db;

        $this->orderModel = new OrderModel($this->db);
    }

    public function GetAll() {
        return $this->orderModel->DbGetAll();
    }

    public function GetByID(int $id) {
        return $this->orderModel->DbGetByID($id);
    }

    public function GetByUserID(array $data) {
        $ret = [];
        $userID = isset($data['user_id']) ? $data['user_id'] : null;

        if (!empty($userID)) {
            $ret = $this->orderModel->DbGetByUserID($userID);
        }

        return $ret;
    }

    public function Save(array $data) {
        return $this->orderModel->DbSave($data);
    }
}