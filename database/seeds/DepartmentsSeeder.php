<?php

use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('departments')->insert([
            ['name' => 'CIVIL'],
            ['name' => 'CSE/IT'],
            ['name' => 'ECE'],
            ['name' => 'EEE'],
            ['name' => 'MECH'],
            ['name' => 'BIO-TECH'],
            ['name' => 'MCA'],
            ['name' => 'MATHS']
            ]);
    }
}
