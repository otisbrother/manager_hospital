<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TypePatientSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['id' => 'TN', 'name' => 'Tại nạn'],
            ['id' => 'CV', 'name' => 'Chuyển viện'],
            ['id' => 'TK', 'name' => 'Tái Khám'],
        ];

        foreach ($types as $type) {
            DB::table('type_patients')->insert([
                'id' => $type['id'],
                'name' => $type['name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
