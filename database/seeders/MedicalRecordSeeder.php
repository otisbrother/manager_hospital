<?php

namespace Database\Seeders; 
use App\Models\MedicalRecord;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [295, 'SKB9458'],
            [623, 'SKB2701'],
            [839, 'SKB6124'],
            [105, 'SKB8593'],
            [428, 'SKB4387'],
            [969, 'SKB5231'],
            [671, 'SKB1386'],
            [754, 'SKB7029'],
            [560, 'SKB3917'],
            [315, 'SKB9265'],
            [487, 'SKB7421'],
            [197, 'SKB0174'],
            [766, 'SKB3579'],
            [508, 'SKB6280'],
            [888, 'SKB7934'],
            [405, 'SKB5847'],
            [290, 'SKB8594'],
            [181, 'SKB2498'],
            [947, 'SKB9015'],
            [576, 'SKB1309'],
            [936, 'SKB6637'],
            [875, 'SKB7356'],
            [633, 'SKB4712'],
            [233, 'SKB8642'],
            [758, 'SKB5176'],
            [852, 'SKB9413'],
            [312, 'SKB1987'],
            [511, 'SKB3874'],
            [968, 'SKB5764'],
            [149, 'SKB8205'],
        ];

        foreach ($data as [$order, $id]) {
            MedicalRecord::create([
                'id' => $id,
                'order' => $order,
            ]);
        }
    }
}
