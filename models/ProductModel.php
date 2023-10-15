<?php
require_once __DIR__ . '/../config/DatabaseConfig.php';
class ProductModel {
    private $connection;

    public function __construct() {
        $dbConfig = DatabaseConfig::getInstance();
        $this->connection = $dbConfig->getConnection();
    }

    public function getProductsByCouponId($couponId) {
        try {
            $stmt = $this->connection->prepare(
                "SELECT p.* FROM `product` p
                 INNER JOIN `product_coupon` pc ON p.id = pc.product_id
                 WHERE pc.coupon_id = :couponId"
            );
            $stmt->bindParam(":couponId", $couponId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Error querying data getProductsByCouponId() " . $e->getMessage());
        }
    }
}

// $productModel = new ProductModel();
// $products = $productModel->getProductsByCouponId(1);
// print_r($products);