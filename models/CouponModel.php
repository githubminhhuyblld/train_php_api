<?php
require_once '../config/DatabaseConfig.php';


class CouponModel {
    private $connection;

    public function __construct() {
        $dbConfig = DatabaseConfig::getInstance();
        $this->connection = $dbConfig->getConnection();
    }

    public function getAllCoupons() {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM coupon");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Error query data getAllCoupons() " . $e->getMessage());
        }
    }

    public function getCouponById($id) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM coupon WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Error query data getCouponById() " . $e->getMessage());
        }
    }

}
//Test
// $couponModel = new CouponModel();
// $coupon = $couponModel->getCouponById(1);
// print_r($coupon);

