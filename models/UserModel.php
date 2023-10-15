<?php
require_once __DIR__ . '/../config/DatabaseConfig.php';
class UserModel
{
    private $connection;

    public function __construct() {
        $dbConfig = DatabaseConfig::getInstance();
        $this->connection = $dbConfig->getConnection();
    }
    public function getUsersByCouponId($couponId) {
        try {
            $stmt = $this->connection->prepare("SELECT u.* FROM `user` u
                      INNER JOIN `user_coupon` uc ON u.id = uc.user_id
                      WHERE uc.coupon_id = :couponId");
            $stmt->bindParam(":couponId", $couponId, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Error querying data getUsersByCouponId() " . $e->getMessage());
        }
    }
}

// $userModel = new UserModel();
// $users = $userModel->getUsersByCouponId(1);
// print_r($users);