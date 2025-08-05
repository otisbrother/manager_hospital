<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prescription;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['id' => 'AB1234', 'doctor_id' => 'BS001', 'patient_id' => 'BN10200'],
            ['id' => 'CD5678', 'doctor_id' => 'BS007', 'patient_id' => 'BN10201'],
            ['id' => 'EF9012', 'doctor_id' => 'BS003', 'patient_id' => 'BN10202'],
            ['id' => 'GH3456', 'doctor_id' => 'BS021', 'patient_id' => 'BN10203'],
            ['id' => 'IJ7890', 'doctor_id' => 'BS007', 'patient_id' => 'BN10204'],
            ['id' => 'KL2345', 'doctor_id' => 'BS013', 'patient_id' => 'BN10205'],
            ['id' => 'MN6789', 'doctor_id' => 'BS016', 'patient_id' => 'BN10206'],
            ['id' => 'OP0123', 'doctor_id' => 'BS019', 'patient_id' => 'BN10207'],
            ['id' => 'QR4567', 'doctor_id' => 'BS012', 'patient_id' => 'BN10208'],
            ['id' => 'ST8901', 'doctor_id' => 'BS009', 'patient_id' => 'BN10209'],
            ['id' => 'UV2345', 'doctor_id' => 'BS016', 'patient_id' => 'BN10210'],
            ['id' => 'WX6789', 'doctor_id' => 'BS002', 'patient_id' => 'BN10211'],
            ['id' => 'YZ0123', 'doctor_id' => 'BS009', 'patient_id' => 'BN10212'],
            ['id' => 'BA4567', 'doctor_id' => 'BS010', 'patient_id' => 'BN10213'],
            ['id' => 'CD8901', 'doctor_id' => 'BS010', 'patient_id' => 'BN10214'],
            ['id' => 'EF2345', 'doctor_id' => 'BS021', 'patient_id' => 'BN10215'],
            ['id' => 'GH6789', 'doctor_id' => 'BS021', 'patient_id' => 'BN10216'],
            ['id' => 'IJ0123', 'doctor_id' => 'BS016', 'patient_id' => 'BN10217'],
            ['id' => 'KL4567', 'doctor_id' => 'BS018', 'patient_id' => 'BN10218'],
            ['id' => 'MN8901', 'doctor_id' => 'BS018', 'patient_id' => 'BN10219'],
            ['id' => 'OP2345', 'doctor_id' => 'BS011', 'patient_id' => 'BN10220'],
            ['id' => 'QR6789', 'doctor_id' => 'BS001', 'patient_id' => 'BN10221'],
            ['id' => 'ST0123', 'doctor_id' => 'BS001', 'patient_id' => 'BN10222'],
            ['id' => 'UV4567', 'doctor_id' => 'BS015', 'patient_id' => 'BN10223'],
            ['id' => 'WX8901', 'doctor_id' => 'BS011', 'patient_id' => 'BN10224'],
            ['id' => 'YZ2345', 'doctor_id' => 'BS015', 'patient_id' => 'BN10225'],
            ['id' => 'BA6789', 'doctor_id' => 'BS015', 'patient_id' => 'BN10226'],
            ['id' => 'CD0123', 'doctor_id' => 'BS011', 'patient_id' => 'BN10227'],
            ['id' => 'EF4567', 'doctor_id' => 'BS011', 'patient_id' => 'BN10228'],
            ['id' => 'GH8901', 'doctor_id' => 'BS015', 'patient_id' => 'BN10229'],
        ];

        foreach ($data as $item) {
            Prescription::create($item);
        }
    }
}
