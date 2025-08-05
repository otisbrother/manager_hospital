<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kiểm tra xem admin đã tồn tại chưa
        $admin = User::where('email', 'admin@gmail.com')->first();
        
        if ($admin) {
            $this->command->info('ℹ️ Admin user already exists!');
            $this->command->info('📧 Email: ' . $admin->email);
            $this->command->info('🔑 Password: password');
            return;
        }

        // Tạo user admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',    
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->command->info('✅ Admin user created successfully!');
        $this->command->info('📧 Email: admin@gmail.com');
        $this->command->info('🔑 Password: password');
    }
} 