<?php

namespace App\Helpers;

class MoneyHelper
{
    /**
     * Format số tiền theo định dạng Việt Nam
     * 
     * @param float $amount Số tiền
     * @param string $currency Đơn vị tiền tệ
     * @return string Số tiền đã format
     */
    public static function format($amount, $currency = 'VNĐ')
    {
        return number_format($amount, 0, ',', '.') . ' ' . $currency;
    }

    /**
     * Format số tiền với màu sắc
     * 
     * @param float $amount Số tiền
     * @param string $currency Đơn vị tiền tệ
     * @param string $color Màu sắc (green, red, blue, orange)
     * @return string HTML với số tiền đã format
     */
    public static function formatWithColor($amount, $currency = 'VNĐ', $color = 'green')
    {
        $colorClass = 'text-' . $color . '-600';
        return '<span class="font-semibold ' . $colorClass . '">' . self::format($amount, $currency) . '</span>';
    }

    /**
     * Kiểm tra xem số tiền có đủ điều kiện áp dụng bảo hiểm không
     * 
     * @param float $amount Số tiền
     * @return bool
     */
    public static function isEligibleForInsurance($amount)
    {
        return $amount >= 1000000; // 1 triệu VNĐ
    }

    /**
     * Tính số tiền bảo hiểm chi trả
     * 
     * @param float $amount Tổng tiền
     * @param float $percentage Phần trăm bảo hiểm
     * @return float Số tiền bảo hiểm chi trả
     */
    public static function calculateInsuranceAmount($amount, $percentage)
    {
        if (!self::isEligibleForInsurance($amount)) {
            return 0;
        }
        
        return ($amount * $percentage) / 100;
    }

    /**
     * Tính số tiền bệnh nhân phải trả
     * 
     * @param float $amount Tổng tiền
     * @param float $insuranceAmount Số tiền bảo hiểm chi trả
     * @return float Số tiền bệnh nhân phải trả
     */
    public static function calculatePatientAmount($amount, $insuranceAmount)
    {
        return $amount - $insuranceAmount;
    }
} 