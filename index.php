<?php
  require_once 'config/DatabaseConfig.php';
  
  try {
      $dbConfig = DatabaseConfig::getInstance();
      $connection = $dbConfig->getConnection();
  
    
      $stmt = $connection->prepare("SELECT * FROM coupon");
      $stmt->execute();
  
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo "<pre>";
      print_r($results);
      echo "</pre>";
  
      echo "Kết nối cơ sở dữ liệu thành công và truy vấn thành công!";
  } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();
  }

  
  
  
  

?>