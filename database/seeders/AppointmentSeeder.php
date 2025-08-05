<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use Carbon\Carbon;
use Faker\Factory as Faker;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        $patients = Patient::all();
        $doctors = Doctor::all();
        $departments = Department::all();

        if ($patients->isEmpty() || $doctors->isEmpty() || $departments->isEmpty()) {
            $this->command->warn('⚠️ Thiếu dữ liệu để tạo lịch hẹn (patients/doctors/departments)');
            return;
        }

        for ($i = 0; $i < 30; $i++) {
            $patient = $patients->random();
            $doctor = $doctors->random();
            $department = Department::find($doctor->department_id); // Khoa tương ứng với bác sĩ

            Appointment::create([
                'patient_id'       => $patient->id,           // VD: BN10200
                'doctor_id'        => $doctor->id,            // VD: BS001
                'department_id'    => $department->id,        // VD: KH001
                'appointment_date' => Carbon::now()->addDays(rand(1, 14))->setHour(rand(8, 16))->setMinute(0),
                'symptoms'         => $faker->sentence(6),
                'status'           => $faker->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
                'notes'            => rand(0, 1) ? $faker->sentence(8) : null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->command->info('✅ Đã tạo 30 lịch hẹn mẫu.');
    }
}
