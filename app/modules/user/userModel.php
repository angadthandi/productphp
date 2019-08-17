<?php

class UserModel {
    private $db;
    private $tblName = 'user';

    public function __construct(DBHelperController $db) {
        $this->db = $db;
    }

    public function DbGetAll() {
        return $this->db->PrepareAndExecute(
            'SELECT * FROM ' . $this->tblName, []
        );
    }

    public function DbGetByID(int $id) {
        return $this->db->PrepareAndExecute(
            'SELECT * FROM ' . $this->tblName . '
            WHERE id=:id',
            [':id'=>$id]
        );
    }

    public function DbGetByUserTypeID(int $userTypeID) {
        return $this->db->PrepareAndExecute(
            'SELECT * FROM ' . $this->tblName . '
            WHERE user_type_id=:user_type_id',
            [':user_type_id'=>$userTypeID]
        );
    }

    public function DbSave(array $arr) {
        $ret = [];

        // begin
        $this->db->BeginTransaction();

        if ($arr['id'] === 0) {
            $ret = $this->_insert($arr);
        } else {
            $ret = $this->_update($arr);
        }

        if ($ret === false) {
            // rollback...
            $this->db->RollBackTransaction();
        }

        // commit
        $this->db->CommitTransaction();

        return $ret;
    }

    private function _insert(array $arr) {
        $ret = false;

        $params = [];
        foreach($arr as $key => $value) {
            if ($key === 'id') continue;

            $params[':' . $key] = $value;
        }

        $ret = $this->db->PrepareAndExecute(
            'INSERT INTO ' . $this->tblName .
            '(user_type_id,
            username,
            password,
            email,
            token)
            VALUES
            (:user_type_id,
            :username,
            :password,
            :email,
            :token)',
            $params
        );

        if ($ret === false) { return $ret; }

        $arr['id'] = $this->db->LastInsertId();

        return $arr;
    }

    private function _update(array $arr) {
        $ret = false;

        $sql = 'UPDATE ' . $this->tblName . ' SET ';

        $paramStr = '';
        $params = [];
        foreach($arr as $key => $value) {
            $paramStr .= $key . '= :' . $key . ',';

            $params[':' . $key] = $value;
        }
        $sql .= rtrim($paramStr, ", ");

        $sql .= ' WHERE id = :id';

        $ret = $this->db->PrepareAndExecute($sql, $params);

        if ($ret === false) { return $ret; }

        return $arr;
    }
}