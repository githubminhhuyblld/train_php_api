SELECT c.* 
FROM coupon c
LEFT JOIN user_coupon uc ON c.id = uc.coupon_id
LEFT JOIN product_coupon pc ON c.id = pc.coupon_id
LEFT JOIN store_coupon sc ON c.id = sc.coupon_id
WHERE 
    (IFNULL(:userId, 0) = 0 OR uc.user_id = :userId)
AND 
    (IFNULL(:productId, 0) = 0 OR pc.product_id = :productId)
AND 
    (IFNULL(:storeId, 0) = 0 OR sc.store_id = :storeId)
GROUP BY c.id;
