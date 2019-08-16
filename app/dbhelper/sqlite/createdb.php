<?php

class CreateSqliteDB {
    private $dbPath = null;

    public function __construct($db) {
        $this->dbPath = $db;
    }

    public function createPathToDb() {
        // if the path does not exist, create it.
        if (!file_exists($this->dbPath)){
            error_log('INFO: trying to create database directory');

            if(!mkdir($this->dbPath, 0770, true)){
                error_log("Unable to create Database Directory.");
                die();
            }
        }
    }

    public function New(PDO $db) {
        error_log('INFO: trying to create new database');

        $db->beginTransaction();

        $db->exec(
            'CREATE TABLE `product_type` (
                `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                `type`	VARCHAR(20) NOT NULL
            );'
        );

        $db->exec(
            'CREATE TABLE `product` (
                `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                `product_type_id`	INTEGER NOT NULL,
                `product_name`	VARCHAR(50) NOT NULL,
                `product_image`	VARCHAR(50) NULL,
                `product_description`	TEXT NULL,
                `product_price`	NUMERIC NOT NULL DEFAULT 0.00
            );'
        );

        // TODO - run in DB
        $db->exec(
            'CREATE TABLE `cart` (
                `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                `user_id`	INTEGER NOT NULL,
                `product_id`	INTEGER NOT NULL
            );'
        );

        $db->exec(
            'CREATE TABLE `order` (
                `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                `total_amount`	INTEGER NOT NULL,
                `user_id`	INTEGER NOT NULL
            );'
        );

        $db->exec(
            'CREATE TABLE `order_product` (
                `order_id`	INTEGER NOT NULL,
                `product_id`	INTEGER NOT NULL,
                `quantity`	INTEGER NOT NULL
            );'
        );

        // TODO - run in DB
        $db->exec(
            'CREATE TABLE `user_type` (
                `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                `type`	VARCHAR(20) NOT NULL
            );'
        );

        // TODO - run in DB
        $db->exec(
            'CREATE TABLE `user` (
                `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                `user_type_id`	INTEGER NOT NULL,
                `username`	VARCHAR(50) NULL,
                `password`	VARCHAR(50) NULL,
                `email`	VARCHAR(100) NULL,
                `token`	VARCHAR(100) NULL
            );'
        );

        // insert default product types
        $db->exec(
            "INSERT INTO product_type (type) VALUES ('pizza');"
        );
        $db->exec(
            "INSERT INTO product_type (type) VALUES ('drink');"
        );

        // TODO - run in DB
        // insert default user types
        $db->exec(
            "INSERT INTO user_type (type) VALUES ('admin');"
        );
        $db->exec(
            "INSERT INTO user_type (type) VALUES ('user');"
        );
        $db->exec(
            "INSERT INTO user_type (type) VALUES ('guest');"
        );

        $db->commit();

        return true;
    }
}