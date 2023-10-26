<?php

class Coupon {

    private $id;
    private $coupon_code;
    private $description;
    private $discount_amount;
    private $start_date;
    private $end_date;
    private $expiration_date;
    private $status;
    private $delete_flag;

    public function __construct(
        $id, 
        $coupon_code, 
        $description, 
        $discount_amount, 
        $start_date, 
        $end_date, 
        $expiration_date, 
        $status, 
        $delete_flag
    ) {
        $this->id = $id;
        $this->coupon_code = $coupon_code;
        $this->description = $description;
        $this->discount_amount = $discount_amount;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->expiration_date = $expiration_date;
        $this->status = $status;
        $this->delete_flag = $delete_flag;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getCouponCode() {
        return $this->coupon_code;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDiscountAmount() {
        return $this->discount_amount;
    }

    public function getStartDate() {
        return $this->start_date;
    }

    public function getEndDate() {
        return $this->end_date;
    }

    public function getExpirationDate() {
        return $this->expiration_date;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDeleteFlag() {
        return $this->delete_flag;
    }

    // Setters
    public function setCouponCode($coupon_code) {
        $this->coupon_code = $coupon_code;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setDiscountAmount($discount_amount) {
        $this->discount_amount = $discount_amount;
    }

    public function setStartDate($start_date) {
        $this->start_date = $start_date;
    }

    public function setEndDate($end_date) {
        $this->end_date = $end_date;
    }

    public function setExpirationDate($expiration_date) {
        $this->expiration_date = $expiration_date;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setDeleteFlag($delete_flag) {
        $this->delete_flag = $delete_flag;
    }
    public static function fromArray($data) {
        return new self(
            $data['id'],
            $data['coupon_code'],
            $data['description'],
            $data['discount_amount'],
            $data['start_date'],
            $data['end_date'],
            $data['expiration_date'],
            $data['status'],
            $data['delete_flag']
        );
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'coupon_code' => $this->coupon_code,
            'description' => $this->description,
            'discount_amount' => $this->discount_amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'expiration_date' => $this->expiration_date,
            'status' => $this->status,
            'delete_flag' => $this->delete_flag,

        ];
    }
    
    

}
