<?php

require_once __DIR__ . "/routesInterface.php";

require_once __DIR__ . '/../modules/order/orderController.php';
require_once __DIR__ . '/../modules/product/productController.php';

class PostController implements IRoutes {
    public function __construct() {
        
    }

    public static function Type() {
        return 'POST';
    }

    public function Handle(DBHelperController $db, array $data) {
        $ret = [];
        $action = $data['action'];
        $dataArr = $data['data'];

        switch ($action) {
            case 'pizza':
            case 'drink':
                $product = new ProductController($db);
                $ret = $product->Save($action, $dataArr);
            break;

            case 'order':
                $order = new OrderController($db);
                $ret = $order->Save($dataArr);
            break;

            default:
                error_log('Invalid action: ' . $action);
                $ret = ['error'=>'Invalid action: ' . $action];
        }

        return $ret;
    }
}