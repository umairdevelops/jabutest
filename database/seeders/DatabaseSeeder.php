<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            ['name' => 'user', "email" => "user@mail.com", "password" => bcrypt("password")],
        ]);

        DB::table('task_groups')->insert([
            ['name' => 'Office Tasks', "description" => "Task to be done at office"],
            ['name' => 'Home Tasks', "description" => "Task to be done at home"],
            ['name' => 'Study Tasks', "description" => "Task to be done at school"],
            ['name' => 'Game Tasks', "description" => "Task to be done at ground"]
        ]);
    }
}
