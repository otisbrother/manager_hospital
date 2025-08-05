<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RelativeSeeder extends Seeder
{
    public function run(): void
    {
        $relatives = [
            ['patient_id' => 'BN10200', 'name' => 'Trần Thanh Hà',         'gender' => 'Nữ',  'dob' => '1995-08-01', 'relationship' => 'Mẹ'],
            ['patient_id' => 'BN10201', 'name' => 'Nguyễn Văn Khánh',      'gender' => 'Nam', 'dob' => '2001-12-15', 'relationship' => 'Người nhà'],
            ['patient_id' => 'BN10200', 'name' => 'Lê Thị Trâm Anh',       'gender' => 'Nữ',  'dob' => '1999-03-07', 'relationship' => 'Má'],
            ['patient_id' => 'BN10203', 'name' => 'Phạm Hoàng Minh',       'gender' => 'Nam', 'dob' => '2005-09-23', 'relationship' => 'Người nhà'],
            ['patient_id' => 'BN10206', 'name' => 'Đặng Trung Hiếu',       'gender' => 'Nam', 'dob' => '1994-06-18', 'relationship' => 'Người nhà'],
            ['patient_id' => 'BN10207', 'name' => 'Vũ Đức Thành',          'gender' => 'Nam', 'dob' => '2008-11-29', 'relationship' => 'Người nhà'],
            ['patient_id' => 'BN10210', 'name' => 'Hoàng Thị Ngọc Anh',    'gender' => 'Nữ',  'dob' => '1996-02-03', 'relationship' => 'Người nhà'],
            ['patient_id' => 'BN10212', 'name' => 'Bùi Thị Minh Châu',     'gender' => 'Nữ',  'dob' => '2000-07-11', 'relationship' => 'Người nhà'],
            ['patient_id' => 'BN10214', 'name' => 'Nguyễn Hữu Phúc',       'gender' => 'Nam', 'dob' => '1992-05-22', 'relationship' => 'Người nhà'],
            ['patient_id' => 'BN10210', 'name' => 'Trịnh Thiên Tân',       'gender' => 'Nam', 'dob' => '2003-10-27', 'relationship' => 'Người nhà'],
            ['patient_id' => 'BN10213', 'name' => 'Mai Thị Thanh Huyền',   'gender' => 'Nữ',  'dob' => '1997-04-09', 'relationship' => 'Người nhà'],
            ['patient_id' => 'BN10204', 'name' => 'Lưu Minh Đức',          'gender' => 'Nam', 'dob' => '2002-01-14', 'relationship' => 'Người nhà'],
        ];

        foreach ($relatives as $relative) {
            DB::table('relative')->updateOrInsert(
                [
                    'patient_id' => $relative['patient_id'],
                    'name' => $relative['name']
                ],
                [
                    'gender' => $relative['gender'],
                    'dob' => $relative['dob'],
                    'relationship' => $relative['relationship'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
