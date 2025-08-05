<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('detail_prescription')->insert([
            ['prescription_id' => 'AB1234', 'medicine_id' => 'R34T9',  'quantity' => 5],
            ['prescription_id' => 'CD5678', 'medicine_id' => '5G89E',  'quantity' => 5],
            ['prescription_id' => 'EF9012', 'medicine_id' => 'Z9H4A',  'quantity' => 4],
            ['prescription_id' => 'GH3456', 'medicine_id' => '7J6L8',  'quantity' => 2],
            ['prescription_id' => 'IJ7890', 'medicine_id' => 'K2N1S',  'quantity' => 3],
            ['prescription_id' => 'KL2345', 'medicine_id' => '3M6R7',  'quantity' => 4],
            ['prescription_id' => 'MN6789', 'medicine_id' => 'P1K8L',  'quantity' => 6],
            ['prescription_id' => 'OP0123', 'medicine_id' => '9B2T6',  'quantity' => 5],
            ['prescription_id' => 'QR4567', 'medicine_id' => 'L3V8F',  'quantity' => 7],
            ['prescription_id' => 'ST8901', 'medicine_id' => '4G7S2',  'quantity' => 2],
            ['prescription_id' => 'UV2345', 'medicine_id' => 'R36D4',  'quantity' => 4],
            ['prescription_id' => 'WX6789', 'medicine_id' => 'D0G43',  'quantity' => 5],
            ['prescription_id' => 'YZ0123', 'medicine_id' => 'EX91T',  'quantity' => 6],
            ['prescription_id' => 'BA4567', 'medicine_id' => 'L91Q8',  'quantity' => 4],
            ['prescription_id' => 'CD8901', 'medicine_id' => 'L0YJ9',  'quantity' => 3],
            ['prescription_id' => 'EF2345', 'medicine_id' => '5G89E',  'quantity' => 5],
            ['prescription_id' => 'GH6789', 'medicine_id' => 'R34T9',  'quantity' => 2],
            ['prescription_id' => 'IJ0123', 'medicine_id' => 'L0YJ9',  'quantity' => 3],
            ['prescription_id' => 'KL4567', 'medicine_id' => 'EX91T',  'quantity' => 5],
            ['prescription_id' => 'MN8901', 'medicine_id' => 'L0YJ9',  'quantity' => 6],
            ['prescription_id' => 'OP2345', 'medicine_id' => 'EX91T',  'quantity' => 6],
            ['prescription_id' => 'QR6789', 'medicine_id' => 'L0YJ9',  'quantity' => 7],
            ['prescription_id' => 'ST0123', 'medicine_id' => 'L3V8F',  'quantity' => 8],
            ['prescription_id' => 'UV4567', 'medicine_id' => '4G7S2',  'quantity' => 9],
            ['prescription_id' => 'WX8901', 'medicine_id' => 'R34T9',  'quantity' => 7],
            ['prescription_id' => 'YZ2345', 'medicine_id' => '4G7S2',  'quantity' => 6],
            ['prescription_id' => 'BA6789', 'medicine_id' => 'R34T9',  'quantity' => 4],
            ['prescription_id' => 'CD0123', 'medicine_id' => '4G7S2',  'quantity' => 3],
            ['prescription_id' => 'EF4567', 'medicine_id' => '4G7S2',  'quantity' => 5],
            ['prescription_id' => 'GH8901', 'medicine_id' => '4G7S2',  'quantity' => 2],
        ]);
    }
}
