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
    private function validateExistence($checks)
    {
        foreach ($checks as $table => $id) {
            if (!$this->couponModel->idExists($id, $table)) {
                ResponseHandler::jsonResponseNotFound(ucfirst($table) . ' ID ' . $id . ' not found', 404);
                return false;
            }
        }
        return true;
    }

    public function getCouponsByStoreId($storeId)
    {

        $checks = array(
            'store' => $storeId

        );

        $isValid = $this->validateExistence($checks);
        $couponModel = new CouponModel();

        $coupons = $couponModel->getCouponsByStoreId($storeId);
        ResponseHandler::jsonResponse($coupons);
    }

    private function getCouponsByUserId($userId)
    {
        $couponModel = new CouponModel();
        $coupons = $couponModel->getCouponsByUserId($userId);
        $userModel = new UserModel();



        ResponseHandler::jsonResponse($coupons);
    }

    private function getCouponsByProductId($productId)
    {
        $couponModel = new CouponModel();
        $coupons = $couponModel->getCouponsByProductId($productId);
        $productModel = new ProductModel();


        ResponseHandler::jsonResponse($coupons);
    }

    private function getCouponsByProductIds($productIds)
    {

        $couponModel = new CouponModel();
        $coupons = $couponModel->getCouponsByProductIds($productIds);
        ResponseHandler::jsonResponse($coupons);
    }

    public function getCouponsByStoreIdAndUserIdProductId($userId, $storeId, $productId)
    {
        $checks = array(
            'store' => $storeId,
            'user' => $userId,
            'product' => $productId
        );
        $couponModel = new CouponModel();
        $isValid = $this->validateExistence($checks);
        if (!$isValid) {
            return;
        }
        $coupons = $couponModel->getCouponsByUserIdProductIdStoreId($userId, $productId, $storeId);
        ResponseHandler::jsonResponse($coupons, null, 200);
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
                $coupons = $this->getCouponsByStoreIdAndUserIdProductId($userId, $storeId, $productId);
                break;

            case $userId && $storeId:
                echo "1";
                break;

            case $userId:
                $coupons = $couponModel->getCouponsByUserId($userId);
                break;

            case $storeId:
                $coupons = $this->getCouponsByStoreId($storeId);
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
