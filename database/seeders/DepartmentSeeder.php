<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'id' => 'KH001',
                'name' => 'Khoa Nội khoa',
                'location' => 'Tầng 2, Nhà A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'KH002',
                'name' => 'Khoa Ngoại khoa',
                'location' => 'Tầng 3, Nhà B',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'KH003',
                'name' => 'Khoa Tai mũi họng',
                'location' => 'Tầng 4, Nhà C',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'KH004',
                'name' => 'Khoa Răng Hàm Mặt',
                'location' => 'Tầng 2, Nhà B',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'KH005',
                'name' => 'Khoa Mắt',
                'location' => 'Tầng 2, Nhà D',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'KH006',
                'name' => 'Khoa Sản',
                'location' => 'Tầng 3, Nhà A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'KH007',
                'name' => 'Khoa Nhi',
                'location' => 'Tầng 4, Nhà B',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'KH008',
                'name' => 'Khoa Tim mạch',
                'location' => 'Tầng 5, Nhà C',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'KH009',
                'name' => 'Khoa Tiêu hóa',
                'location' => 'Tầng 6, Nhà A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'KH010',
                'name' => 'Khoa Ung bướu',
                'location' => 'Tầng 7, Nhà D',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
