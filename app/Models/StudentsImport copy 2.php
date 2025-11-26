<?php

namespace App\Models;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class StudentsImport implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
    private $rows = 0;

    public function collection(Collection $rows)
    {
        $canImport = true;
        $user = Auth::user();

        if ($canImport) {
            foreach ($rows as $row) {
                $school_id = $row['school_id'];
                $class_id = $this->getClassId($row['class'], $school_id);
                $section_id = $this->getSectionId($row['section'], $class_id);

                if($row['parent_user_type'] == "Father") {
                    $parent_user_id = $this->getParentUserId($row['father_name'], $row['father_email'], $row['father_contact_no']);
                } elseif($row['parent_user_type'] == "Mother") {
                    $parent_user_id = $this->getParentUserId($row['mother_name'], $row['mother_email'], $row['mother_contact_no']);
                } else {
                    $parent_user_id = $this->getParentUserId($row['ecp_name'], $row['ecp_email'], $row['ecp_contact_no']);
                }

                $studentId = Student::create([
                    'name'              => $row['name'],
                    'dob'               => Carbon::createFromTimestamp(($row['dob'] - 25569) * 86400)->format('Y-m-d'),
                    'age'               => $row['age'],
                    'sex'               => $row['sex'],
                    'school_id'         => $school_id,
                    'class_id'          => $class_id,
                    'section_id'        => $section_id,
                    'roll'              => $row['roll'],
                    'home_address'      => $row['home_address'],
                    'parent_user_type'  => $row['parent_user_type'],
                    'parent_user_id'    => $parent_user_id,
                    'father_name'       => $row['father_name'],
                    'father_age'        => $row['father_age'],
                    'father_profession' => $row['father_profession'],
                    'father_email'      => $row['father_email'],
                    'father_contact_no' => $row['father_contact_no'],
                    'mother_name'       => $row['mother_name'],
                    'mother_age'        => $row['mother_age'],
                    'mother_profession' => $row['mother_profession'],
                    'mother_email'      => $row['mother_email'],
                    'mother_contact_no' => $row['mother_contact_no'],
                    'ecp_name'          => $row['ecp_name'],
                    'ecp_relationship'  => $row['ecp_relationship'],
                    'ecp_email'         => $row['ecp_email'],
                    'ecp_contact_no'    => $row['ecp_contact_no'],
                    'family_income_range' => $row['family_income_range'],
                    'added_by'          => $user->id,
                ]);
            }

            flash(translate('Student imported successfully'))->success();
        }
    }

    public function model(array $row)
    {
        ++$this->rows;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'], // Ensures that name is a required string
        ];
    }

    public function getClassId($class_name, $school_id) {
        try {
            $class = Classes::where('name', $class_name)->where('school_id', $school_id)->first();

            if(empty($class)) {
                $class = new Classes;
                $class->name = $class_name;
                $class->school_id = $school_id;
            } else {
                $class = Classes::findOrFail($class->id);
                $class->name = $class_name;
                $class->school_id = $school_id;
            }
            
            $class->save();

            return $class->id;
        } catch (\Exception $e) {

        }
        return null;
    }

    public function getSectionId($section_name, $class_id) {
        try {
            $section = Section::where('name', $section_name)->where('class_id', $class_id)->first();
            if(empty($section)) {
                $section = new Section;
                $section->name = $section_name;
                $section->class_id = $class_id;
            } else {
                $section = Section::findOrFail($section->id);
                $section->name = $section_name;
                $section->class_id = $class_id;
            }
            $section->save();

            return $section->id;
        } catch (\Exception $e) {

        }
        return null;
    }

    public function getParentUserId($name, $email, $phone) {
        $user = new User();
        $user->user_type = 'parent';
        $user->name = $name;
        $user->phone = $phone;
        if ($email) {
            $user->email = $email;
        }
        $user->password = bcrypt('123456');
        $user->verification_code = rand(100000, 999999);
        $user->save();

        if ($user->save()) {
            // Add Staff 
            $userrole = new UserRole();
            $userrole->user_id = $user->id;
            $userrole->role_id = 7;
            $user->assignRole(Role::findOrFail(7)->name);
            $userrole->save();
        }

        return $user->id;
    }
}
