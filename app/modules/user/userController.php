<?php

require_once __DIR__ . "/usrModel.php";

class UserController {
    private $db;
    private $userModel;

    public function __construct(DBHelperController $db) {
        $this->db = $db;

        $this->userModel = new UserModel($this->db);
    }

    public function GetAll() {
        return $this->userModel->DbGetAll();
    }

    public function GetByID(int $id) {
        return $this->userModel->DbGetByID($id);
    }

    public function GetByUserID(array $data) {
        $ret = [];
        $userTypeID = isset($data['user_type_id']) ? $data['user_type_id'] : null;

        if (!empty($userTypeID)) {
            $ret = $this->userModel->DbGetByUserTypeID($userTypeID);
        }

        return $ret;
    }

    public function Save(array $data) {
        return $this->userModel->DbSave($data);
    }
}