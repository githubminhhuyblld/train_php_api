<?php
require_once __DIR__ . '/../response/ResponseHandler.php';
require_once __DIR__ . '/../requests/RequestHandler.php';
require_once __DIR__ . '/../models/CouponModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/StoreModel.php';

class CouponController
{
    private $couponModel;

    public function __construct()
    {
        $this->couponModel = new CouponModel();
    }

    public function getAllCoupons()
    {
        try {
            $coupons = $this->couponModel->getAllCoupons();
            if ($coupons) {
                ResponseHandler::jsonResponse($coupons);
            }
        } catch (Exception $e) {
            die("Controller getAllCoupons: " . $e->getMessage());
        }
    }

    public function getCouponById($couponId)
    {
        try {
            $coupons = $this->couponModel->getCouponById($couponId);

            if ($coupons) {
                ResponseHandler::jsonResponse($coupons);
            } else {
                ResponseHandler::jsonResponse(null, 'Coupon not found', 404);
            }
        } catch (Exception $e) {
            echo "Controller getCouponById:" . $e->getMessage();
        }
    }

    public function getCouponsByStoreId($storeId)
    {
        $storeModel = new StoreModel();
        $couponModel = new CouponModel();
        $store = $storeModel->getStoreById($storeId);
        if (!$store) {
            ResponseHandler::jsonResponseNotFound('storeId not found', 404);
            return;
        }

        $coupons = $couponModel->getCouponsByStoreId($storeId);
        // $storeModel = new StoreModel();
        // $response = [];

        // foreach ($coupons as $coupon) {
        //     $stores = $storeModel->getStoresByCouponId($coupon['id']);
        //     $coupon['stores'] = $stores;
        //     $response[] = $coupon;
        // }

        ResponseHandler::jsonResponse($coupons);
    }

    private function getCouponsByUserId($userId)
    {
        $couponModel = new CouponModel();
        $coupons = $couponModel->getCouponsByUserId($userId);
        $userModel = new UserModel();

        $response = [];

        foreach ($coupons as $coupon) {
            $users = $userModel->getUsersByCouponId($coupon['id']);
            $coupon['users'] = $users;
            $response[] = $coupon;
        }

        ResponseHandler::jsonResponse($response);
    }

    private function getCouponsByProductId($productId)
    {
        $couponModel = new CouponModel();
        $coupons = $couponModel->getCouponsByProductId($productId);
        $productModel = new ProductModel();

        $response = [];

        foreach ($coupons as $coupon) {
            $products = $productModel->getProductsByCouponId($coupon['id']);
            $coupon['products'] = $products;
            $response[] = $coupon;
        }

        ResponseHandler::jsonResponse($response);
    }

    private function getCouponsByProductIds($productIds)
    {
        $couponModel = new CouponModel();
        $coupons = $couponModel->getCouponsByProductIds($productIds);
        $productModel = new ProductModel();

        $response = [];

        foreach ($coupons as $coupon) {
            $products = $productModel->getProductsByCouponId($coupon['id']);
            $coupon['products'] = $products;
            $response[] = $coupon;
        }

        ResponseHandler::jsonResponse($response);
    }


    public function filterCoupon($productId = null, $storeId = null, $userId = null)
    {
        if ($productId) {
            $this->getCouponsByProductId($productId);
        } elseif ($storeId) {
            $this->getCouponsByStoreId($storeId);
        } elseif ($userId) {
            $this->getCouponsByUserId($userId);
        } else {
            ResponseHandler::jsonResponse(null, 'Invalid filters', 400);
        }
    }

    public function filterCouponAnd($userId = null, $storeId = null, $productId = null)
    {
        $couponModel = new CouponModel();

        switch (true) {
            case $userId && $productId && $storeId:
                $coupons = $couponModel->getCouponsByUserIdProductIdStoreId($userId, $productId, $storeId);
                break;

            case $userId && $productId:
                $coupons = $couponModel->getCouponsByUserIdAndProductId($userId, $productId);
                break;

            case $userId:
                $coupons = $couponModel->getCouponsByUserId($userId);
                break;

            case $storeId:
                $coupons = $couponModel->getCouponsByStoreId($storeId);
                break;

            case $productId:
                $coupons = $couponModel->getCouponsByProductId($productId);
                break;

            default:
                $coupons = null;
                break;
        }

        ResponseHandler::jsonResponse($coupons);
    }
}
// $couponController = new CouponController();
// $allCoupons = $couponController->filterCouponAnd(1, 1, 1);
// print_r($allCoupons);
