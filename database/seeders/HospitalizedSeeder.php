<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HospitalizedSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['BN10200', '2023-02-01', 'MA759', 6],
            ['BN10201', '2023-03-14', 'BA123', 7],
            ['BN10205', '2023-05-19', 'TA708', 5],
            ['BN10207', '2022-12-02', 'LA902', 4],
            ['BN10209', '2022-11-22', 'CA476', 11],
            ['BN10211', '2022-08-11', 'RA582', 5],
            ['BN10213', '2022-07-30', 'FA305', 6],
            ['BN10214', '2022-06-25', 'HA694', 7],
            ['BN10215', '2022-04-17', 'SA888', 8],
            ['BN10216', '2022-03-09', 'NA265', 9],
            ['BN10220', '2022-01-24', 'PA409', 9],
            ['BN10222', '2022-12-17', 'KA176', 11],
            ['BN10221', '2022-11-05', 'DA941', 2],
            ['BN10225', '2022-09-28', 'GA528', 12],
        ];

        foreach ($data as [$pid, $date, $room, $bed]) {
            DB::table('hospitalized')->insert([
                'patient_id' => $pid,
                'admission_date' => Carbon::parse($date),
                'room' => $room,
                'bed' => $bed,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
