SELECT c.*
FROM coupon c
LEFT JOIN user_coupon uc ON c.id = uc.coupon_id
LEFT JOIN product_coupon pc ON c.id = pc.coupon_id
LEFT JOIN store_coupon sc ON c.id = sc.coupon_id
WHERE 
    (
        (c.start_date IS NOT NULL AND c.start_date <= CURDATE() AND (c.end_date IS NULL OR c.end_date > CURDATE()))
        OR
        (c.start_date IS NULL AND c.end_date IS NOT NULL AND c.end_date > CURDATE())
    )
AND 
    (IFNULL(:userId, 0) = 0 OR uc.user_id = :userId)
AND 
    (IFNULL(:productId, 0) = 0 OR pc.product_id = :productId)
AND 
    (IFNULL(:storeId, 0) = 0 OR sc.store_id = :storeId)
GROUP BY c.id;




-- SELECT c.* 
-- FROM coupon c
-- LEFT JOIN user_coupon uc ON c.id = uc.coupon_id
-- LEFT JOIN product_coupon pc ON c.id = pc.coupon_id
-- LEFT JOIN store_coupon sc ON c.id = sc.coupon_id
-- WHERE 
--     (
--         NVL(:userId, 0) = 0 OR uc.user_id = :userId
--     )
--     AND 
--     (
--         NVL(:productId, 0) = 0 OR pc.product_id = :productId
--     )
--     AND 
--     (
--         NVL(:storeId, 0) = 0 OR sc.store_id = :storeId
--     )
--     AND
--     (
--         c.status = 'Active'
--     )
--     AND
--     (
--         c.delete_flag = 0
--     )
--     AND
--     (
--         (
--             -- Hiệu lực khi có ngày bắt đầu và có ngày kết thúc
--             (c.start_date IS NOT NULL AND c.end_date IS NOT NULL AND c.start_date <= SYSDATE AND c.end_date >= SYSDATE)
--             -- Hiệu lực khi chỉ có ngày bắt đầu, không quan tâm đến ngày kết thúc
--             OR (c.start_date IS NOT NULL AND c.end_date IS NULL AND c.start_date <= SYSDATE)
--             -- Hiệu lực khi không có cả ngày bắt đầu và ngày kết thúc
--             OR (c.start_date IS NULL AND c.end_date IS NULL)
--         )
--     )
-- GROUP BY c.id;


