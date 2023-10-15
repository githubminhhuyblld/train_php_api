<?php
require_once __DIR__ . '/../config/DatabaseConfig.php';
class StoreModel {
    private $connection;

    public function __construct() {
        $dbConfig = DatabaseConfig::getInstance();
        $this->connection = $dbConfig->getConnection();
    }

    public function getStoresByCouponId($couponId) {
        try {
            $stmt = $this->connection->prepare(
                "SELECT s.* FROM `store` s
                 INNER JOIN `store_coupon` sc ON s.id = sc.store_id
                 WHERE sc.coupon_id = :couponId"
            );
            $stmt->bindParam(":couponId", $couponId, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Error querying data getStoresByCouponId() " . $e->getMessage());
        }
    }
    public function getStoreById($storeId) {
        $sql = "SELECT *  FROM store WHERE id = :storeId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":storeId", $storeId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
}

// $storeModel = new StoreModel();
// $stores = $storeModel->getStoresByCouponId(1);
// print_r($stores);