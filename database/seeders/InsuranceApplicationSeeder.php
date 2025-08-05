<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InsuranceApplication;
use App\Models\Patient;
use Carbon\Carbon;

class InsuranceApplicationSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy một số bệnh nhân để tạo đăng ký
        $patients = Patient::take(3)->get();
        
        if ($patients->isEmpty()) {
            $this->command->info('Không có bệnh nhân nào để tạo đăng ký mức hỗ trợ.');
            return;
        }

        $supportLevels = ['80', '95', '100'];
        
        foreach ($patients as $index => $patient) {
            InsuranceApplication::create([
                'patient_id' => $patient->id,
                'insurance_id' => 'BHYT' . str_pad($patient->id, 6, '0', STR_PAD_LEFT),
                'support_level' => $supportLevels[$index % 3],
                'status' => 'pending',
                'proof_images' => $supportLevels[$index % 3] === '80' ? null : ['sample_proof_1.jpg', 'sample_proof_2.jpg'],
                'admin_notified' => false,
                'created_at' => Carbon::now()->subHours(rand(1, 12)), // Tạo trong 12 giờ qua
                'updated_at' => Carbon::now()->subHours(rand(1, 12)),
            ]);
        }

        $this->command->info('Đã tạo ' . $patients->count() . ' đăng ký mức hỗ trợ viện phí test.');
    }
} 