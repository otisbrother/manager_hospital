<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['id' => 'HD4567', 'health_insurance_id' => 'HS40101208700', 'patient_id' => 'BN10200', 'prescription_id' => 'AB1234'],
            ['id' => 'HD8124', 'health_insurance_id' => 'DN40101208798', 'patient_id' => 'BN10201', 'prescription_id' => 'CD5678'],
            ['id' => 'HD2658', 'health_insurance_id' => 'CN40101207432', 'patient_id' => 'BN10202', 'prescription_id' => 'EF9012'],
            ['id' => 'HD7991', 'health_insurance_id' => 'DS40101208621', 'patient_id' => 'BN10203', 'prescription_id' => 'GH3456'],
            ['id' => 'HD0336', 'health_insurance_id' => 'CD40102718831', 'patient_id' => 'BN10204', 'prescription_id' => 'IJ7890'],
            ['id' => 'HD9885', 'health_insurance_id' => 'CD40102717487', 'patient_id' => 'BN10205', 'prescription_id' => 'KL2345'],
            ['id' => 'HD1233', 'health_insurance_id' => 'DS40101203512', 'patient_id' => 'BN10206', 'prescription_id' => 'MN6789'],
            ['id' => 'HD6570', 'health_insurance_id' => 'HS40101208701', 'patient_id' => 'BN10207', 'prescription_id' => 'OP0123'],
            ['id' => 'HD4440', 'health_insurance_id' => 'CD40102710987', 'patient_id' => 'BN10208', 'prescription_id' => 'QR4567'],
            ['id' => 'HD9019', 'health_insurance_id' => 'HS40101208799', 'patient_id' => 'BN10209', 'prescription_id' => 'ST8901'],
            ['id' => 'HD0358', 'health_insurance_id' => 'DS40101208321', 'patient_id' => 'BN10210', 'prescription_id' => 'UV2345'],
            ['id' => 'HD7392', 'health_insurance_id' => 'CD40102711183', 'patient_id' => 'BN10211', 'prescription_id' => 'WX6789'],
            ['id' => 'HD5898', 'health_insurance_id' => 'DS40101205421', 'patient_id' => 'BN10212', 'prescription_id' => 'YZ0123'],
            ['id' => 'HD5573', 'health_insurance_id' => 'HS40101208749', 'patient_id' => 'BN10213', 'prescription_id' => 'BA4567'],
            ['id' => 'HD7352', 'health_insurance_id' => 'CD40102714458', 'patient_id' => 'BN10214', 'prescription_id' => 'CD8901'],
            ['id' => 'HD2983', 'health_insurance_id' => 'HS40101218438', 'patient_id' => 'BN10215', 'prescription_id' => 'EF2345'],
            ['id' => 'HD9917', 'health_insurance_id' => 'DS40101202233', 'patient_id' => 'BN10216', 'prescription_id' => 'GH6789'],
            ['id' => 'HD6148', 'health_insurance_id' => 'HS40101218749', 'patient_id' => 'BN10217', 'prescription_id' => 'IJ0123'],
            ['id' => 'HD3899', 'health_insurance_id' => 'DS40101255332', 'patient_id' => 'BN10218', 'prescription_id' => 'KL4567'],
            ['id' => 'HD2089', 'health_insurance_id' => 'DS40101275363', 'patient_id' => 'BN10219', 'prescription_id' => 'MN8901'],
        ];

        foreach ($data as &$row) {
            $row['total'] = rand(1000000, 10000000); // Tổng tiền giả lập
            $row['created_at'] = now();
            $row['updated_at'] = now();
        }

        DB::table('bills')->insert($data);
    }
}
