<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\HealthInsurance;
use App\Helpers\MoneyHelper;

class BillCalculationService
{
    /**
     * Tính toán số tiền phải thanh toán dựa trên bảo hiểm y tế
     * 
     * @param float $totalAmount Tổng tiền gốc
     * @param Patient $patient Thông tin bệnh nhân
     * @return array Thông tin chi tiết về tính toán
     */
    public function calculateBillWithInsurance($totalAmount, Patient $patient)
    {
        $originalAmount = $totalAmount;
        $insuranceAmount = 0;
        $patientAmount = $totalAmount;
        $insurancePercentage = 0;
        $hasInsurance = false;

        // Kiểm tra xem bệnh nhân có bảo hiểm y tế không
        if ($patient->insurance_id && $patient->insurance) {
            $hasInsurance = true;
            
            // Kiểm tra điều kiện áp dụng bảo hiểm
            if (!MoneyHelper::isEligibleForInsurance($totalAmount)) {
                $insuranceAmount = 0;
                $patientAmount = $totalAmount;
                $insurancePercentage = 0;
            } else {
                // Ưu tiên sử dụng mức hỗ trợ từ hồ sơ đăng ký BHYT đã được duyệt
                $approvedApplication = $patient->insuranceApplications()
                    ->where('status', 'approved')
                    ->latest()
                    ->first();
                
                if ($approvedApplication) {
                    // Sử dụng mức hỗ trợ từ hồ sơ đăng ký đã duyệt
                    $insurancePercentage = (float) $approvedApplication->support_level;
                } else {
                    // Fallback: sử dụng mức hỗ trợ từ bảng health_insurance
                    $insurancePercentage = $patient->insurance->coverage_percentage ?? 80;
                }
                
                // Tính số tiền bảo hiểm chi trả
                $insuranceAmount = MoneyHelper::calculateInsuranceAmount($totalAmount, $insurancePercentage);
                
                // Số tiền bệnh nhân phải trả
                $patientAmount = MoneyHelper::calculatePatientAmount($totalAmount, $insuranceAmount);
            }
        }

        return [
            'original_amount' => $originalAmount,
            'insurance_amount' => $insuranceAmount,
            'patient_amount' => $patientAmount,
            'insurance_percentage' => $insurancePercentage,
            'has_insurance' => $hasInsurance,
            'insurance_id' => $patient->insurance_id,
            'insurance_info' => $patient->insurance
        ];
    }

    /**
     * Tính toán số tiền cho nhiều đơn thuốc
     * 
     * @param array $prescriptions Danh sách đơn thuốc
     * @param Patient $patient Thông tin bệnh nhân
     * @return array Thông tin chi tiết về tính toán
     */
    public function calculateMultiplePrescriptions($prescriptions, Patient $patient)
    {
        $totalOriginalAmount = 0;
        $totalInsuranceAmount = 0;
        $totalPatientAmount = 0;
        $prescriptionDetails = [];

        foreach ($prescriptions as $prescription) {
            $prescriptionTotal = 0;
            
            // Tính tổng tiền cho đơn thuốc này
            foreach ($prescription->details as $detail) {
                $prescriptionTotal += ($detail->medicine->price ?? 0) * ($detail->quantity ?? 1);
            }

            $totalOriginalAmount += $prescriptionTotal;
            
            // Tính toán với bảo hiểm cho đơn thuốc này
            $calculation = $this->calculateBillWithInsurance($prescriptionTotal, $patient);
            
            $totalInsuranceAmount += $calculation['insurance_amount'];
            $totalPatientAmount += $calculation['patient_amount'];
            
            $prescriptionDetails[] = [
                'prescription_id' => $prescription->id,
                'original_amount' => $prescriptionTotal,
                'insurance_amount' => $calculation['insurance_amount'],
                'patient_amount' => $calculation['patient_amount'],
                'calculation' => $calculation
            ];
        }

        return [
            'total_original_amount' => $totalOriginalAmount,
            'total_insurance_amount' => $totalInsuranceAmount,
            'total_patient_amount' => $totalPatientAmount,
            'prescription_details' => $prescriptionDetails,
            'has_insurance' => $patient->insurance_id && $patient->insurance,
            'insurance_id' => $patient->insurance_id,
            'insurance_info' => $patient->insurance
        ];
    }
} 