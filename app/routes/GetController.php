<?php

require_once __DIR__ . "/routesInterface.php";

require_once __DIR__ . '/../modules/order/orderController.php';
require_once __DIR__ . '/../modules/product/productController.php';

class GetController implements IRoutes {
    public function __construct() {
        
    }

    public static function Type() {
        return 'GET';
    }

    public function Handle(DBHelperController $db, array $data) {
        $ret = [];
        $action = $data['action'];

        switch ($action) {
            case 'products':
                $product = new ProductController($db);
                $ret = $product->GetAll();
            break;

            case 'pizza':
            case 'drink':
                $product = new ProductController($db);
                $ret = $product->GetAllByType($action);
            break;

            case 'cartCountByUserID':
                $cart = new CartController($db);
                $ret = $cart->CountAllByUserID($data);
            break;

            case 'cartByUserID':
                $cart = new CartController($db);
                $ret = $cart->GetAllByUserID($data);
            break;

            case 'order':
                $order = new OrderController($db);
                $ret = $order->GetAll();
            break;

            case 'orderByUserID':
                $order = new OrderController($db);
                $ret = $order->GetByUserID($data);
            break;

            default:
                error_log('Invalid action: ' . $action);
                $ret = ['error'=>'Invalid action: ' . $action];
        }

        return $ret;
    }
}