<?php

class ProductModel {
    private $db;
    private $tblName = 'product';

    public function __construct(DBHelperController $db) {
        $this->db = $db;
    }

    public function DbGetAll() {
        return $this->db->PrepareAndExecute(
            'SELECT * FROM ' . $this->tblName, []
        );
    }

    public function DbGetProductTypeID(string $productType) {
        $ret = $this->db->PrepareAndExecute(
            'SELECT id FROM product_type where type=:product_type',
            [':product_type'=>$productType]
        );

        return $ret[0]['id'];
    }

    public function DbGetAllByType(string $productType) {
        $productTypeID = $this->DbGetProductTypeID($productType);

        return $this->db->PrepareAndExecute(
            'SELECT * FROM ' . $this->tblName . '
            WHERE product_type_id=:product_type_id',
            [':product_type_id'=>$productTypeID]
        );
    }

    public function DbGetByID(int $id) {
        return $this->db->PrepareAndExecute(
            'SELECT * FROM ' . $this->tblName . '
            WHERE id=:id',
            [':id'=>$id]
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
            '(product_type_id,
            product_name,
            product_image,
            product_description,
            product_price)
            VALUES
            (:product_type_id,
            :product_name,
            :product_image,
            :product_description,
            :product_price)',
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