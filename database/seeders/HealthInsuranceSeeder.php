<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class HealthInsuranceSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        $data = [
            ['id' => 'HS40101208700', 'start' => '19-02-2020', 'end' => '19-02-2022', 'type' => 'Học sinh', 'coverage' => 80.00],
            ['id' => 'DN40101208798', 'start' => '15-07-2021', 'end' => '15-07-2023', 'type' => 'Doanh nghiệp', 'coverage' => 85.00],
            ['id' => 'CN40101207432', 'start' => '24-08-2022', 'end' => '24-08-2024', 'type' => 'Công nhân', 'coverage' => 80.00],
            ['id' => 'DS40101208621', 'start' => '05-04-2019', 'end' => '05-04-2021', 'type' => 'Đối tượng xã hội', 'coverage' => 95.00],
            ['id' => 'CD40102718831', 'start' => '04-06-2018', 'end' => '04-06-2020', 'type' => 'Cán bộ công chức', 'coverage' => 90.00],
            ['id' => 'CD40102717487', 'start' => '17-02-2020', 'end' => '17-02-2022', 'type' => 'Cán bộ công chức', 'coverage' => 90.00],
            ['id' => 'DS40101203512', 'start' => '18-12-2022', 'end' => '18-12-2024', 'type' => 'Đối tượng xã hội', 'coverage' => 95.00],
            ['id' => 'HS40101208701', 'start' => '15-01-2022', 'end' => '15-01-2024', 'type' => 'Học sinh', 'coverage' => 80.00],
            ['id' => 'CD40102710987', 'start' => '25-11-2021', 'end' => '25-11-2023', 'type' => 'Cán bộ công chức', 'coverage' => 90.00],
            ['id' => 'HS40101208799', 'start' => '19-10-2022', 'end' => '19-10-2024', 'type' => 'Học sinh', 'coverage' => 80.00],
            ['id' => 'DS40101208321', 'start' => '29-04-2023', 'end' => '29-04-2025', 'type' => 'Đối tượng xã hội', 'coverage' => 95.00],
            ['id' => 'CD40102711183', 'start' => '16-05-2022', 'end' => '16-05-2024', 'type' => 'Cán bộ công chức', 'coverage' => 90.00],
            ['id' => 'DS40101205421', 'start' => '11-05-2021', 'end' => '11-05-2023', 'type' => 'Đối tượng xã hội', 'coverage' => 95.00],
            ['id' => 'HS40101208749', 'start' => '09-07-2022', 'end' => '09-07-2024', 'type' => 'Học sinh', 'coverage' => 80.00],
            ['id' => 'CD40102714458', 'start' => '04-08-2018', 'end' => '04-08-2020', 'type' => 'Cán bộ công chức', 'coverage' => 90.00],
            ['id' => 'HS40101218438', 'start' => '19-02-2020', 'end' => '19-02-2022', 'type' => 'Học sinh', 'coverage' => 80.00],
            ['id' => 'DS40101202233', 'start' => '15-07-2021', 'end' => '15-07-2023', 'type' => 'Đối tượng xã hội', 'coverage' => 95.00],
            ['id' => 'HS40101218749', 'start' => '24-08-2022', 'end' => '24-08-2024', 'type' => 'Học sinh', 'coverage' => 80.00],
            ['id' => 'DS40101255332', 'start' => '05-04-2019', 'end' => '05-04-2021', 'type' => 'Đối tượng xã hội', 'coverage' => 95.00],
            ['id' => 'DS40101275363', 'start' => '17-02-2020', 'end' => '17-02-2022', 'type' => 'Đối tượng xã hội', 'coverage' => 95.00],
            ['id' => 'HS40101217329', 'start' => '15-01-2022', 'end' => '15-01-2024', 'type' => 'Học sinh', 'coverage' => 80.00],
            ['id' => 'HS40101213769', 'start' => '29-04-2023', 'end' => '29-04-2025', 'type' => 'Học sinh', 'coverage' => 80.00],
            ['id' => 'CD40101714458', 'start' => '11-05-2021', 'end' => '11-05-2023', 'type' => 'Cán bộ công chức', 'coverage' => 90.00],
            ['id' => 'CD40101715758', 'start' => '16-05-2022', 'end' => '16-05-2024', 'type' => 'Cán bộ công chức', 'coverage' => 90.00],
            ['id' => 'DS40101206217', 'start' => '04-08-2018', 'end' => '04-08-2020', 'type' => 'Đối tượng xã hội', 'coverage' => 95.00],
            ['id' => 'CD40106714458', 'start' => '24-08-2022', 'end' => '24-08-2024', 'type' => 'Cán bộ công chức', 'coverage' => 90.00],
            ['id' => 'HS40101228473', 'start' => '09-07-2022', 'end' => '09-07-2024', 'type' => 'Học sinh', 'coverage' => 80.00],
            ['id' => 'DS40101206325', 'start' => '04-06-2018', 'end' => '04-06-2020', 'type' => 'Đối tượng xã hội', 'coverage' => 95.00],
            ['id' => 'CD40108714458', 'start' => '15-01-2022', 'end' => '15-01-2024', 'type' => 'Cán bộ công chức', 'coverage' => 90.00],
            ['id' => 'CD40106371458', 'start' => '24-08-2022', 'end' => '24-08-2024', 'type' => 'Cán bộ công chức', 'coverage' => 90.00],
        ];
        

        foreach ($data as $item) {
          DB::table('health_insurance')->insert([
        'id' => $item['id'],
        'register_date' => Carbon::createFromFormat('d-m-Y', $item['start'])->format('Y-m-d'),
        'expire_date' => Carbon::createFromFormat('d-m-Y', $item['end'])->format('Y-m-d'),
        'type' => $item['type'],
        'coverage_percentage' => $item['coverage'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

    }
}
