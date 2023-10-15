<?php
require_once '../response/ResponseHandler.php';
require_once '../requests/RequestHandler.php';
require_once '../methods/HttpMethods.php';
require_once '../controllers/CouponController.php';


$method = RequestHandler::getRequestMethod();
$uri = RequestHandler::getRequestUri();

$couponController = new CouponController();
switch ($uri) {
    case '/train_php_api/coupons':
        if ($method == HttpMethods::GET) {
            // $couponController->getAllCoupons();
            $couponController->getCouponById(1);
        }
        break;

    default:
        ResponseHandler::jsonResponse(null, 'URL not found', 404);
        break;
}
