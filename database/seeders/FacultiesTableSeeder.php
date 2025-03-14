<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultiesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('faculties')->insert([
            ['faculty_name' => 'FDSS', 'parent_faculty' => null, 'created_by' => null, 'updated_by' => null],
            ['faculty_name' => 'FMSH', 'parent_faculty' => null, 'created_by' => null, 'updated_by' => null],
            ['faculty_name' => 'FOM', 'parent_faculty' => null, 'created_by' => null, 'updated_by' => null],
            ['faculty_name' => 'FOE', 'parent_faculty' => null, 'created_by' => null, 'updated_by' => null],
            ['faculty_name' => 'FOL', 'parent_faculty' => null, 'created_by' => null, 'updated_by' => null],
            ['faculty_name' => 'FAHC', 'parent_faculty' => null, 'created_by' => null, 'updated_by' => null],
            ['faculty_name' => 'FOC', 'parent_faculty' => null, 'created_by' => null, 'updated_by' => null],
            ['faculty_name' => 'FBAS', 'parent_faculty' => null, 'created_by' => null, 'updated_by' => null],
            ['faculty_name' => 'FOT', 'parent_faculty' => null, 'created_by' => null, 'updated_by' => null],
            ['faculty_name' => 'FOCJ', 'parent_faculty' => null, 'created_by' => null, 'updated_by' => null],
            ['faculty_name' => 'FBESS', 'parent_faculty' => null, 'created_by' => null, 'updated_by' => null],
        ]);
    }
}
