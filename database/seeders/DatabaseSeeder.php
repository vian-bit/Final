<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Departments
        $departments = [
            ['name' => 'Front Office', 'code' => 'FO', 'description' => 'Front Office Department'],
            ['name' => 'Housekeeping', 'code' => 'HK', 'description' => 'Housekeeping Department'],
            ['name' => 'Food & Beverage', 'code' => 'FB', 'description' => 'Food & Beverage Department'],
            ['name' => 'Engineering', 'code' => 'ENG', 'description' => 'Engineering Department'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Create Superuser
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@hotel.com',
            'password' => Hash::make('password'),
            'role' => 'superuser',
            'is_active' => true,
        ]);

        // Create Admin for each department
        $deptIds = Department::pluck('id', 'code');
        
        User::create([
            'name' => 'Admin Front Office',
            'email' => 'admin.fo@hotel.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department_id' => $deptIds['FO'],
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Admin Housekeeping',
            'email' => 'admin.hk@hotel.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department_id' => $deptIds['HK'],
            'is_active' => true,
        ]);

        // Create sample users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@hotel.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'department_id' => $deptIds['FO'],
            'user_type' => 'magang',
            'start_date' => now(),
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@hotel.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'department_id' => $deptIds['HK'],
            'user_type' => 'daily_worker',
            'start_date' => now(),
            'is_active' => true,
        ]);
    }
}
