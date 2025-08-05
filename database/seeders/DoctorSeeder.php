<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            // Các bác sĩ chưa kích hoạt tài khoản (email được admin cấp, chưa có password)
            ['id' => 'BS001', 'name' => 'Trần Minh Huy', 'gender' => 'Nam', 'department_id' => 'KH001', 'email' => 'BS001_doctor@gmail.com'],
            ['id' => 'BS002', 'name' => 'Nguyễn Thị Kim Anh', 'gender' => 'Nữ', 'department_id' => 'KH002', 'email' => 'BS002_doctor@gmail.com'],
            ['id' => 'BS003', 'name' => 'Lê Văn Tùng', 'gender' => 'Nam', 'department_id' => 'KH003', 'email' => 'BS003_doctor@gmail.com'],
            ['id' => 'BS004', 'name' => 'Phạm Thị Mai', 'gender' => 'Nữ', 'department_id' => 'KH004', 'email' => 'BS004_doctor@gmail.com'],
            ['id' => 'BS005', 'name' => 'Đặng Quang Tú', 'gender' => 'Nam', 'department_id' => 'KH005', 'email' => 'BS005_doctor@gmail.com'],
            ['id' => 'BS006', 'name' => 'Võ Thị Lan Anh', 'gender' => 'Nữ', 'department_id' => 'KH006', 'email' => 'BS006_doctor@gmail.com'],
            ['id' => 'BS007', 'name' => 'Hoàng Minh Tuấn', 'gender' => 'Nam', 'department_id' => 'KH007', 'email' => 'BS007_doctor@gmail.com'],
            ['id' => 'BS008', 'name' => 'Lý Mai Linh', 'gender' => 'Nữ', 'department_id' => 'KH008', 'email' => 'BS008_doctor@gmail.com'],
            ['id' => 'BS009', 'name' => 'Mai Văn Hiệu', 'gender' => 'Nam', 'department_id' => 'KH009', 'email' => 'BS009_doctor@gmail.com'],
            ['id' => 'BS010', 'name' => 'Đỗ Thị Hải Yến', 'gender' => 'Nữ', 'department_id' => 'KH010', 'email' => 'BS010_doctor@gmail.com'],
            ['id' => 'BS011', 'name' => 'Nguyễn Văn Thành', 'gender' => 'Nam', 'department_id' => 'KH001', 'email' => 'BS011_doctor@gmail.com'],
            ['id' => 'BS012', 'name' => 'Trần Thúy Hạnh', 'gender' => 'Nữ', 'department_id' => 'KH002', 'email' => 'BS012_doctor@gmail.com'],
            ['id' => 'BS013', 'name' => 'Hoàng Thế Nam', 'gender' => 'Nam', 'department_id' => 'KH006', 'email' => 'BS013_doctor@gmail.com'],
            ['id' => 'BS014', 'name' => 'Ngô Văn Tâm', 'gender' => 'Nam', 'department_id' => 'KH006', 'email' => 'BS014_doctor@gmail.com'],
            ['id' => 'BS015', 'name' => 'Bùi Thị Kim Hạnh', 'gender' => 'Nữ', 'department_id' => 'KH007', 'email' => 'BS015_doctor@gmail.com'],
            ['id' => 'BS016', 'name' => 'Vương Thị Thuý Nhi', 'gender' => 'Nữ', 'department_id' => 'KH007', 'email' => 'BS016_doctor@gmail.com'],
            ['id' => 'BS017', 'name' => 'Đinh Văn Toàn', 'gender' => 'Nam', 'department_id' => 'KH005', 'email' => 'BS017_doctor@gmail.com'],
            ['id' => 'BS018', 'name' => 'Nguyễn Thị Thu Hằng', 'gender' => 'Nữ', 'department_id' => 'KH005', 'email' => 'BS018_doctor@gmail.com'],
            ['id' => 'BS019', 'name' => 'Lê Văn Bảo', 'gender' => 'Nam', 'department_id' => 'KH010', 'email' => 'BS019_doctor@gmail.com'],
            ['id' => 'BS020', 'name' => 'Trịnh Thị Thanh Tâm', 'gender' => 'Nữ', 'department_id' => 'KH007', 'email' => 'BS020_doctor@gmail.com'],
            ['id' => 'BS021', 'name' => 'Phan Minh Đức', 'gender' => 'Nam', 'department_id' => 'KH010', 'email' => 'BS021_doctor@gmail.com'],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }
    }
}
