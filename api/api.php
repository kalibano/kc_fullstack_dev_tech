<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


require '../database/connection.php'; 
require __DIR__.'/models/category.php';
require __DIR__.'/models/course.php';


header("Access-Control-Allow-Origin: http://cc.localhost");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}




$query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$params = [];
if ($query) {
    parse_str($query, $params);
}

$action = $params['action'] ?? null;

$method = $_SERVER['REQUEST_METHOD'];

switch ($action) {
    case 'categories':
        if ($method === 'GET') {
            echo json_encode(Category::getAll($pdo));
        }
        break;

    case 'courses':
        if ($method === 'GET') {
            $categoryId = $_GET['category_id'] ?? null;
            echo json_encode(Course::getAll($pdo, $categoryId));
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["message" => "Not Found"]);
}
