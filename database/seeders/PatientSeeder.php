<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('vi_VN'); // Sử dụng tiếng Việt

        // Danh sách các mã BHYT đã có trong bảng health_insurance
        $insuranceIds = [
            'HS40101208700', 'DN40101208798', 'CN40101207432',
            'DS40101208621', 'CD40102718831', 'CD40102717487',
            'DS40101203512', 'HS40101208701', 'CD40102710987',
            'HS40101208799', 'DS40101208321', 'CD40102711183',
            'DS40101205421', 'HS40101208749', 'CD40102714458',
            'HS40101218438', 'DS40101202233', 'HS40101218749',
            'DS40101255332', 'DS40101275363', 'HS40101217329',
            'HS40101213769', 'CD40101714458', 'CD40101715758',
            'DS40101206217', 'CD40106714458', 'HS40101228473',
            'DS40101206325', 'CD40108714458', 'CD40106371458',
        ];

        for ($i = 0; $i < 50; $i++) {
            DB::table('patients')->insert([
                'id' => 'BN' . str_pad(10200 + $i, 5, '0', STR_PAD_LEFT), // // BN10200 → BN10249
                'patient_type_id' => $faker->randomElement(['TN', 'CV', 'TK']), // TN: Tai nạn, CV: Chuyển viện, TK: Tái khám
                'insurance_id' => $faker->randomElement($insuranceIds), // ✅ Chọn đúng mã BHYT đã seed
                'name' => $faker->name(),
                'gender' => $faker->randomElement(['Nam', 'Nữ']),
                'date' => $faker->date('Y-m-d', '2005-01-01'), // Ngày sinh trước 2005
                'address' => $faker->address(),
                'phone' => '09' . $faker->numerify('########'), // SĐT dạng 09xxxxxxxx
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
