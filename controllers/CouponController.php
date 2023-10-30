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
        if ($id !== null && !$this->couponModel->idExists($id, $table)) {
            ResponseHandler::jsonResponseNotFound(ucfirst($table) . ' ID ' . $id . ' not found', 404);
            return false;
        }
    }
    return true;
}


    public function getCouponsByUserIdProductIdStoreId($userId,$productId,$storeId)
    {
        $checks = array(
            TableNames::STORE => $storeId,
            TableNames::USER => $userId,
            TableNames::PRODUCT => $productId
        );
    
        $isValid = $this->validateExistence($checks);
        $couponRepository = new CouponRepository();
    
        $coupons = $couponRepository->getCouponsByUserIdProductIdStoreId($userId,$productId,$storeId);
        ResponseHandler::jsonResponse($coupons);
    }
    


}

