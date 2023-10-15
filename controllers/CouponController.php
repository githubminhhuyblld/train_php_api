<?php

require_once '../response/ResponseHandler.php';
require_once '../requests/RequestHandler.php';
require_once '../models/CouponModel.php';

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
}
// $couponController = new CouponController();
// $allCoupons = $couponController->getAllCoupons();
// print_r($allCoupons);
