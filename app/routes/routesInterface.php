<?php

interface IRoutes {
    public static function Type();
    public function Handle(DBHelperController $db, array $data);
}