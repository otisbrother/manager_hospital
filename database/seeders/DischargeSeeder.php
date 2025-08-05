<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DischargeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['patient_id' => 'BN10200', 'discharge_date' => '2023-06-01'],
            ['patient_id' => 'BN10207', 'discharge_date' => '2023-06-05'],
            ['patient_id' => 'BN10205', 'discharge_date' => '2023-05-10'],
            ['patient_id' => 'BN10214', 'discharge_date' => '2023-05-15'],
            ['patient_id' => 'BN10215', 'discharge_date' => '2023-06-19'],
            ['patient_id' => 'BN10215', 'discharge_date' => '2023-05-21'],
            ['patient_id' => 'BN10220', 'discharge_date' => '2023-06-25'],
            ['patient_id' => 'BN10220', 'discharge_date' => '2023-06-28'],
            ['patient_id' => 'BN10221', 'discharge_date' => '2023-06-02'],
            ['patient_id' => 'BN10225', 'discharge_date' => '2023-06-08'],
            ['patient_id' => 'BN10201', 'discharge_date' => '2023-05-11'],
        ];

        foreach ($data as $item) {
            DB::table('discharge')->insert([
                'patient_id'     => $item['patient_id'],
                'discharge_date' => Carbon::parse($item['discharge_date']),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
