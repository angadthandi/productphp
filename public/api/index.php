<?php

require_once __DIR__ . '/../../app/routes/routesController.php';
require_once __DIR__ . "/../../app/routes/GetController.php";
require_once __DIR__ . "/../../app/routes/PostController.php";
require_once __DIR__ . "/../../app/routes/PutController.php";

$response = [];
$method = $_SERVER['REQUEST_METHOD'];

// // TEST GET
// $_GET['action'] = 'products';
// $_GET['action'] = 'pizza';
// $_GET['action'] = 'drink';

// // TEST POST - insert
// $method = 'POST';
// $postData = [
//     'action' => 'drink',
//     'data' => [
//         'id' => 0,
//         'product_name' => 'Mountain Dew',
//         'product_image' => '',
//         'product_description' => '',
//         'product_price' => 3.00,
//     ]
// ];

// // TEST PUT - update
// $method = 'PUT';
// $postData = [
//     'action' => 'drink',
//     'data' => [
//         'id' => 4,
//         'product_name' => 'Sprite',
//         'product_image' => '',
//         'product_description' => '',
//         'product_price' => 3.00,
//     ]
// ];

switch ($method) {
    case GetController::Type():
        $handler = new RoutesController(new GetController());
        $response = $handler->Handle($_GET);
        break;

    case PostController::Type():
    case PutController::Type():
        $postData = json_decode(file_get_contents('php://input'), true);

        $handler = new RoutesController(new PostController());
        $response = $handler->Handle($postData);
        break;

    default:
        error_log("Invalid request: " . $requestType);
        break;
}

// error_log(print_r($response, true));

// Prepare our output stream to return JSON instead of HTML

header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: no-cache");
header("Content-Disposition: inline; filename=\"api.json\"");
header('Content-type: text/json; charset=UTF-8');

// Convert the handler responses (PHP Arrays and Arrays of Arrays) to JSON and output it.
echo json_encode($response);//, JSON_PRETTY_PRINT);