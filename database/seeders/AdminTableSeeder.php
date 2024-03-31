<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Admin = [
            "name" => "super admin",
            "email" => "admin@admin.com",
            "password" => Hash::make("123456789")
        ];

        Admin::truncate();
        Admin::create($Admin);
    }
}
