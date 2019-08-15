<?php

require_once __DIR__ . "/productModel.php";

class ProductController {
    private $db;
    private $productModel;

    public function __construct(DBHelperController $db) {
        $this->db = $db;

        $this->productModel = new ProductModel($this->db);
    }

    public function GetAll() {
        return $this->productModel->DbGetAll();
    }

    public function GetProductTypeID(string $productType) {
        return $this->productModel->DbGetProductTypeID($productType);
    }

    public function GetAllByType(string $productType) {
        return $this->productModel->DbGetAllByType($productType);
    }

    public function GetByID(int $id) {
        return $this->productModel->DbGetByID($id);
    }

    public function Save(string $productType, array $data) {
        $data['product_type_id'] = $this->GetProductTypeID($productType);
        return $this->productModel->DbSave($data);
    }
}