<?php

session_start();
// Get URI.
$request_uri = $_SERVER['REQUEST_URI'];

// Get querystring
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
// var_dump($request_uri);

// Get querystring.
$querystring = $_SERVER['QUERY_STRING'];
// var_dump($querystring);

// Get the querystring parts.
$request_parts = explode('/', $querystring);
// var_dump($request_parts);

// Get request method. (GET, POST etc).
$request_method = strtolower($_SERVER['REQUEST_METHOD']);

// Autoload classes.
spl_autoload_register(function ($class_name) {
    $pathClass = './classes/'.$class_name.'.php';

    if (file_exists($pathClass)) {
        require $pathClass;
    } else {
        http_response_code(501);
    }
});

$class = $request_parts[0];
$args = $request_parts[1] ?? null;
$body_data = $_POST;
$response = [
    'info' => null,
    'results' => null,
];

if (empty($class)) {
    http_response_code(400);
} else {
    $db = new Database();
    $obj = new $class($db, $body_data);

    // Setup router.
    switch ($request_method) {
        // Create record.
        case 'post':
            $secondObj = new $args();
            if ($obj->makeTransfer($secondObj)) {
                $response['info']['no'] = 1;
                $response['info']['message'] = $secondObj->getError();
            } else {
                $response['info']['no'] = 0;
                $response['info']['message'] = $secondObj->getError();
            }
            break;

        // Get records.
        case 'get':
            $data = $obj->$args();
            if ($data) {
                $response['info']['no'] = count($data);
                $response['info']['message'] = 'Returned items.';
                $response['session']['id'] = $_SESSION['id'];
                $response['session']['phone'] = $_SESSION['mobilephone'];
                $response['results'] = $data;
            } else {
                $response['info']['message'] = "Couldn't find any items.";
                $response['info']['no'] = 0;
            }
            break;
    }
}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);
