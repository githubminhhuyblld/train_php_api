<?php
require_once __DIR__ . '/../response/ResponseHandler.php';
require_once __DIR__ . '/../requests/RequestHandler.php';
require_once __DIR__ . '/../repository/CouponRepository.php';
require_once __DIR__ . '/../repository/ProductModel.php';
require_once __DIR__ . '/../repository/UserModel.php';
require_once __DIR__ . '/../repository/StoreModel.php';
require_once __DIR__ . '/../constant/Table.php';

class CouponController
{
    private $couponModel;

    public function __construct()
    {
        $this->couponModel = new CouponRepository();
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
            TableNames::STORE => $storeId
        );
    
        $isValid = $this->validateExistence($checks);
        $couponRepository = new CouponRepository();
    
        $coupons = $couponRepository->getCouponsByStoreId($storeId);
        ResponseHandler::jsonResponse($coupons);
    }
    


    public function filterCouponAnd($userId = null, $storeId = null, $productId = null)
    {
       switch (true) {
        
            case $storeId:
                $coupons = $this->getCouponsByStoreId($storeId);
                break;

            default:
                $coupons = null;
                break;
        }

        ResponseHandler::jsonResponse($coupons);
    }
}
// $couponController = new CouponController();
// $allCoupons = $couponController->filterCouponAnd(1, null, null);
// print_r($allCoupons);
