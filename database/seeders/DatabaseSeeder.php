<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // ✅ Thêm dòng này

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo users mẫu với role khác nhau
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',    
            'password' => Hash::make('password'), // ✅ Sửa lại đúng
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@gmail.com',
            'password' => Hash::make('password'), // ✅ Sửa lại đúng
            'role' => 'doctor',
        ]);

        User::create([
            'name' => 'Patient User',
            'email' => 'patient@gmail.com',
            'password' => Hash::make('password'), // ✅ Sửa lại đúng
            'role' => 'patient',
        ]);

        // Chạy seeders cho bệnh viện theo thứ tự
 $this->call([
        DepartmentSeeder::class,           // 1️⃣ Tạo khoa → Doctor cần
        TypePatientSeeder::class,          // 2️⃣ Tạo loại bệnh nhân → Patient cần
        HealthInsuranceSeeder::class,      // 3️⃣ Tạo bảo hiểm → Patient cần
        PatientSeeder::class,              // 4️⃣ Tạo bệnh nhân → cần TypePatient & HealthInsurance
        RelativeSeeder::class,             // 5️⃣ Tạo thân nhân → cần Patient
        DoctorSeeder::class,               // 6️⃣ Tạo bác sĩ → cần Department
        PrescriptionSeeder::class,         // 7️⃣ Tạo đơn thuốc → cần Doctor & Patient
        MedicineSeeder::class,
        DetailPrescriptionSeeder::class,   // 8️⃣ Chi tiết đơn → cần Prescription & Medicine
        MedicalRecordSeeder::class, 
        DetailMedicalRecordSeeder::class,   
        BillSeeder::class,
        HospitalizedSeeder::class,
        DischargeSeeder::class,
        AppointmentSeeder::class,
        InsuranceApplicationSeeder::class, // 🔔 Tạo đăng ký mức hỗ trợ viện phí
    ]);

    }
}


