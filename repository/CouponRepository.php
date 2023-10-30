<?php
require_once __DIR__ . '/../config/DatabaseConfig.php';
require_once __DIR__ . '/../models/Coupon.php';
require_once __DIR__ . '/../constant/SqlFile.php';



class CouponRepository
{
    private $connection;

    public function __construct()
    {
        $dbConfig = DatabaseConfig::getInstance();
        $this->connection = $dbConfig->getConnection();
    }
    public function getCouponsByUserIdProductIdStoreId($userId,$productId,$storeId)
    {
        try {
            $query = file_get_contents(SQLFiles::GET_COUPONS_BY_STORE_ID);
            if (!$query) {
                die("Error: Unable to read SQL file.");
            }
            $stmt = $this->connection->prepare($query);
        
            $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
            $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);
            $stmt->bindParam(":storeId", $storeId, PDO::PARAM_INT);
            $stmt->execute();     
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $couponObjects = array_map(['Coupon', 'fromArray'], $rows);
            $coupons = array_map(function ($couponObject) {
                return $couponObject->toArray();
            }, $couponObjects);
            
            return $coupons;
        } catch (PDOException $e) {
            die("Error in getCouponsByStoreId() " . $e->getMessage());
        }
    }


    public function idExists($id, $tableName)
    {
        $stmt = $this->connection->prepare("SELECT 1 FROM $tableName WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

   
    



    
   



   

    

    
}
//Test
// $couponModel = new CouponRepository();
// $coupon = $couponModel->getCouponsByStoreId(1);
// print_r($coupon);
