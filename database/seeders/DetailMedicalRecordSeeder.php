<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailMedicalRecord;
use Carbon\Carbon;

class DetailMedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['SKB9458','BN10200','01-01-2022','AB1234','Cảm','KH001'],
            ['SKB9458','BN10201','18-07-2022','CD5678','Đau răng','KH007'],
            ['SKB2701','BN10202','29-08-2022','EF9012','Sốt','KH003'],
            ['SKB2701','BN10203','06-10-2022','GH3456','Cảm','KH010'],
            ['SKB8593','BN10204','24-12-2022','IJ7890','Đau răng','KH007'],
            ['SKB4387','BN10205','11-02-2023','KL2345','Cảm','KH006'],
            ['SKB5231','BN10206','07-04-2023','MN6789','Ho','KH007'],
            ['SKB1386','BN10207','23-06-2023','OP0123','Đau đầu','KH010'],
            ['SKB7029','BN10208','04-08-2023','QR4567','Cảm','KH002'],
            ['SKB3917','BN10209','10-09-2023','ST8901','Sốt','KH009'],
            ['SKB9265','BN10210','09-11-2023','UV2345','Đau răng','KH007'],
            ['SKB7421','BN10211','25-12-2023','WX6789', null,'KH002'],
            ['SKB0174','BN10212','02-01-2022','YZ0123','Cảm','KH002'],
            ['SKB3579','BN10213','14-08-2022','BA4567','Ho','KH010'],
            ['SKB6280','BN10214','21-09-2022','CD8901','Cảm','KH010'],
            ['SKB7934','BN10215','05-11-2022','EF2345','Đau đầu','KH010'],
            ['SKB5847','BN10216','28-12-2022','GH6789','Đau bụng','KH010'],
            ['SKB8594','BN10217','01-03-2023','IJ0123','Cảm','KH007'],
            ['SKB2498','BN10218','26-04-2023','KL4567','Sốt','KH005'],
            ['SKB9015','BN10219','19-07-2023','MN8901','Ho','KH005'],
            ['SKB1309','BN10220','08-10-2023','OP2345','Đau răng','KH001'],
            ['SKB6637','BN10221','12-11-2023','QR6789','Đau mắt','KH001'],
            ['SKB7356','BN10222','18-12-2023','ST0123','Đau bụng','KH001'],
            ['SKB4712','BN10223','05-01-2022','UV4567','Ho','KH007'],
            ['SKB8642','BN10224','06-06-2022','WX8901','Sốt','KH001'],
            ['SKB5176','BN10225','07-09-2022','YZ2345','Đau đầu','KH007'],
            ['SKB9413','BN10226','22-10-2022','BA6789','Ho','KH007'],
            ['SKB1987','BN10227','30-11-2022','CD0123','Đau đầu','KH001'],
            ['SKB3874','BN10228','09-02-2023','EF4567','Đau bụng','KH001'],
            ['SKB5764','BN10229','30-03-2023','GH8901','Đau mắt','KH007'],
        ];

        foreach ($data as [$maskb, $mabn, $ngaykham, $madt, $tenbenh, $makhoa]) {
            DetailMedicalRecord::create([
                'medical_record_id' => $maskb,
                'patient_id'        => $mabn,
                'exam_date'         => Carbon::createFromFormat('d-m-Y', $ngaykham),
                'prescription_id'   => $madt,
                'disease_name'      => $tenbenh,
                'department_id'     => $makhoa,
            ]);
        }
    }
}
