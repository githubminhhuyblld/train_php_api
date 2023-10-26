SELECT c.* 
FROM coupon c
INNER JOIN store_coupon sc ON c.id = sc.coupon_id
WHERE sc.store_id = :storeId
