<?php

require_once __DIR__ . "/cartModel.php";

class CartController {
    private $db;
    private $cartModel;

    public function __construct(DBHelperController $db) {
        $this->db = $db;

        $this->cartModel = new CartModel($this->db);
    }

    public function GetAll() {
        return $this->cartModel->DbGetAll();
    }

    public function CountAllByUserID(array $data) {
        $userID = isset($data['user_id']) ? $data['user_id'] : 0;
        return $this->cartModel->DbCountAllByUserID($userID);
    }

    public function GetAllByUserID(array $data) {
        $userID = isset($data['user_id']) ? $data['user_id'] : 0;
        return $this->cartModel->DbGetAllByUserID($userID);
    }

    public function GetByID(int $id) {
        return $this->cartModel->DbGetByID($id);
    }

    public function Save(array $data) {
        return $this->cartModel->DbSave($data);
    }
}