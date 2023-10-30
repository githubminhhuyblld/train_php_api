<?php
require_once '../response/ResponseHandler.php';
require_once '../requests/RequestHandler.php';
require_once '../methods/HttpMethods.php';
require_once '../controllers/CouponController.php';
require_once 'Router.php';


$method = RequestHandler::getRequestMethod();
// $uri = RequestHandler::getRequestUri();
// echo($uri);
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$couponController = new CouponController();

function validateQueryParams($params) {
    $validParams = array('userId', 'productId', 'storeId');

    // Kiểm tra xem mỗi tham số trong $params có hợp lệ hay không
    foreach ($params as $param => $value) {
        if (!in_array($param, $validParams)) {
            returnError("Invalid query parameter: $param");
        }
    }

    // Kiểm tra giá trị của mỗi tham số
    foreach ($validParams as $vp) {
        if (isset($params[$vp])) {
            if (!is_numeric($params[$vp]) || (int)$params[$vp] <= 0) {
                returnError("Invalid value for $vp.");
            }
        }
    }

    // Kiểm tra xem có ít nhất một tham số được cung cấp hay không
    $isAllNull = true;
    foreach ($validParams as $vp) {
        if (isset($params[$vp]) && !is_null($params[$vp]) && $params[$vp] !== "") {
            $isAllNull = false;
            break;
        }
    }

    if ($isAllNull) {
        returnError('Missing required parameters.');
    }
}

function returnError($message) {
    echo json_encode(array('status' => 'error', 'message' => $message));
    exit;
}



 
$router = new Router();
$router->addRoute(HttpMethods::GET, '/train_php_api/coupons', function() use ($couponController) {
    $userId = RequestHandler::getQueryParam('userId');
    $productId = RequestHandler::getQueryParam('productId');
    $storeId = RequestHandler::getQueryParam('storeId');

    validateQueryParams($_GET);

    $couponController->getCouponsByUserIdProductIdStoreId($userId, $productId, $storeId);
});

// Dispatch the current request to the corresponding route
$router->dispatch($method, $uri);