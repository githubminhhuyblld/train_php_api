<?php
// require_once '../config/DatabaseConfig.php';
require_once __DIR__ . '/../config/DatabaseConfig.php';


class CouponModel
{
    private $connection;

    public function __construct()
    {
        $dbConfig = DatabaseConfig::getInstance();
        $this->connection = $dbConfig->getConnection();
    }

    public function getCouponsByUserIdProductIdStoreId($userId, $productId, $storeId)
    {
        try {
            $query = "
                SELECT c.* 
                FROM coupon c
                INNER JOIN user_coupon uc ON c.id = uc.coupon_id
                INNER JOIN product_coupon pc ON c.id = pc.coupon_id
                INNER JOIN store_coupon sc ON c.id = sc.coupon_id
                WHERE uc.user_id = :userId AND pc.product_id = :productId AND sc.store_id = :storeId
            ";

            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
            $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);
            $stmt->bindParam(":storeId", $storeId, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error in getCouponsByUserIdProductIdStoreId() " . $e->getMessage());
        }
    }
    public function getCouponsByUserIdAndProductId($userId, $productId) {
        try {
            $query = "
                SELECT c.* 
                FROM coupon c
                INNER JOIN user_coupon uc ON c.id = uc.coupon_id
                INNER JOIN product_coupon pc ON c.id = pc.coupon_id
                WHERE uc.user_id = :userId AND pc.product_id = :productId
            ";
    
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
            $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);
    
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error in getCouponsByUserIdAndProductId() " . $e->getMessage());
        }
    }
    
    

    public function getAllCoupons()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM coupon");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error query data getAllCoupons() " . $e->getMessage());
        }
    }

    public function getCouponById($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM coupon WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error query data getCouponById() " . $e->getMessage());
        }
    }

    public function getCouponsByStoreId($storeId)
    {
        try {
            $query = "
                SELECT c.* 
                FROM coupon c
                INNER JOIN store_coupon sc ON c.id = sc.coupon_id
                WHERE sc.store_id = :storeId
            ";

            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":storeId", $storeId, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error in getCouponsByStoreId() " . $e->getMessage());
        }
    }

    public function getCouponsByUserId($userId)
    {
        try {
            $query = "
                SELECT c.* 
                FROM coupon c
                INNER JOIN user_coupon uc ON c.id = uc.coupon_id
                WHERE uc.user_id = :userId
            ";

            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error in getCouponsByStoreId() " . $e->getMessage());
        }
    }

    public function getCouponsByProductId($productId)
    {
        try {
            $stmt = $this->connection->prepare(
                "SELECT c.* 
                FROM coupon c 
                INNER JOIN product_coupon pc ON c.id = pc.coupon_id 
                WHERE pc.product_id = :productId"
            );

            $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error querying data in getCouponsByProductId(): " . $e->getMessage());
        }
    }

    public function getCouponsByProductIds($productIds)
    {
        try {
            $placeholders = implode(',', array_fill(0, count($productIds), '?'));
            $sql = "SELECT * FROM coupon c
                    JOIN product_coupon pc
                    ON c.id = pc.coupon_id
                    WHERE product_id IN ($placeholders)";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute($productIds);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die("Error querying data in getCouponsByProductIds(): " . $e->getMessage());
        }
    }
}
//Test
// $couponModel = new CouponModel();
// $coupon = $couponModel->getCouponById(1);
// print_r($coupon);
