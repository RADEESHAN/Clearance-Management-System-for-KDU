<?php

namespace App\Imports;

use App\Models\User;
use App\Models\StudentInfo;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivationEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UsersImport
{
    const MAX_RECORDS = 300; // Limit to 500 records

    public function import($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        $rows = [];
        foreach ($sheet->getRowIterator() as $rowIndex => $row) {
            if ($rowIndex > self::MAX_RECORDS) {
                break; // Stop processing if the limit is reached
            }

            $cells = [];
            foreach ($row->getCellIterator() as $cell) {
                $columnIndex = $cell->getColumn();
                $cells[$columnIndex] = $this->getCellValue($cell);
            }
            $rows[$rowIndex] = $cells;
        }

        $invalidEmails = [];

        foreach ($rows as $rowIndex => $row) {
            // Skip the header row if it exists
            if ($rowIndex === 1 && strtolower($row['B']) === 'email') {
                continue;
            }

            // Validate email
            $validator = Validator::make(['email' => $row['B']], [
                'email' => 'required|email:rfc,dns'
            ]);

            if ($validator->fails()) {
                $invalidEmails[] = $row['B'];
                continue; // Skip this row and move to the next
            }

            // Generate a password for the new user
            $password = $this->generateStrongPassword();

            // Create or update the user
            $user = User::updateOrCreate(
                ['email' => $row['B']],
                [
                    'user_name' => $row['C'],
                    'reg_no' => $row['A'],
                    'password' => Hash::make($password),
                    'dep_id' => '1',
                    'is_student' => '1',
                    'is_management' => '0',
                    'is_super_admin' => '0'
                ]
            );

            // Insert or update data into student_info table
            StudentInfo::updateOrCreate(
                ['student_reg_no' => $row['A']],
                [
                    'user_id' => $user->id,
                    'tel_no' => $row['E'],
                    'faculty_id' => $row['D'],
                    'student_type' => 'DAYSCHOLAR',
                    'kdu_id' => $row['F'],
                    'nic' => $row['G'],
                    'created_by' => 1,
                    'updated_by' => 1
                ]
            );

            // Send activation email only for newly created users
            if ($user->wasRecentlyCreated) {
                Mail::to($user->email)->send(new ActivationEmail($user, $password));
            }
        }

        return $invalidEmails;
    }

    private function getCellValue(Cell $cell)
    {
        if (\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC === $cell->getDataType() && Date::isDateTime($cell)) {
            return Date::excelToDateTimeObject($cell->getValue())->format('Y-m-d');
        }
        return $cell->getValue();
    }

    private function generateStrongPassword($length = 8)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()_+';

        $all = $uppercase . $lowercase . $numbers . $specialChars;

        $password = '';
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $specialChars[random_int(0, strlen($specialChars) - 1)];

        for ($i = 4; $i < $length; $i++) {
            $password .= $all[random_int(0, strlen($all) - 1)];
        }

        return str_shuffle($password);
    }
}