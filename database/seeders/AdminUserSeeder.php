<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 創建管理員用戶
        User::create([
            'name' => 'Admin',
            'email' => 'admin@hopewonderland.com',
            'password' => Hash::make('admin123'),
            'admin' => true,
        ]);

        $this->command->info('管理員用戶已創建: admin@hopewonderland.com / admin123');
    }
}
