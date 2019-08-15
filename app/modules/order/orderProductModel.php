<?php

class OrderProductModel {
    private $db;
    private $tblName = 'order_product';

    public function __construct(DBHelperController $db) {
        $this->db = $db;
    }

    public function DbGetAll() {
        return $this->db->PrepareAndExecute(
            'SELECT * FROM ' . $this->tblName, []
        );
    }

    public function DbGetByOrderID(int $orderID) {
        return $this->db->PrepareAndExecute(
            'SELECT * FROM ' . $this->tblName . '
            WHERE order_id=:order_id',
            [':order_id'=>$orderID]
        );
    }

    public function DbSave(array $arr) {
        $ret = [];

        // begin
        $this->db->BeginTransaction();

        // insert only...
        $ret = $this->_insert($arr);
        // if ($arr['order_id'] === 0) {
        //     $ret = $this->_insert($arr);
        // } else {
        //     $ret = $this->_update($arr);
        // }

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
            '(order_id,
            product_id,
            quantity)
            VALUES
            (:order_id,
            :product_id,
            :quantity)',
            $params
        );

        if ($ret === false) { return $ret; }

        // $arr['id'] = $this->db->LastInsertId();

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

        $sql .= ' WHERE order_id = :order_id';

        $ret = $this->db->PrepareAndExecute($sql, $params);

        if ($ret === false) { return $ret; }

        return $arr;
    }
}