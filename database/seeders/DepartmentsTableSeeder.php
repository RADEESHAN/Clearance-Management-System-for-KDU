<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'dep_name' => 'Student',
                'email' => null,
                'parent_department' => null,
                'faculty_id' => null // Setting faculty_id as null
            ],
            [
                'dep_name' => 'Top level management',
                'email' => null,
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Top level management',
                'email' => null,
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Asistant Register',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'IT Division',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Log Office',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'FDSS',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Cadet Mess',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Publication',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Sport Division',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Technical Support Office',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Library',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Account Section',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Help Desk',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Enlistment',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],
            [
                'dep_name' => 'Hostal',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => null
            ],

            ////////////////////////////////////////
            [
                'dep_name' => 'AR_FDSS',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => 1
            ],
            [
                'dep_name' => 'AR_FMSH',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => 2
            ],
            [
                'dep_name' => 'AR_FOM',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => 3
            ],
            [
                'dep_name' => 'AR_FOE',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => 4
            ],
            [
                'dep_name' => 'AR_FOL',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => 5
            ],
            [
                'dep_name' => 'AR_Alied_Health_Science',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => 6
            ],
            [
                'dep_name' => 'AR_FOC',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => 7
            ],
            [
                'dep_name' => 'AR_Basic_Appplied_Science',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => 8
            ],
            [
                'dep_name' => 'AR_FOT',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => 9
            ],
            [
                'dep_name' => 'AR_FOCJ',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => 10
            ],
            [
                'dep_name' => 'AR_FBESS',
                'email' => 'tharindumuramudali@gmail.com',
                'parent_department' => null,
                'faculty_id' => 11
            ],
            
        ]);
    }
}