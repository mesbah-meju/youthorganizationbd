<?php

namespace App\Models;

use App\Utility\EmailUtility;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class StudentsImport2 implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
    protected $campus_id;
    protected $shift_id;
    protected $class_id;
    protected $section_id;

    public function __construct($campus_id, $shift_id, $class_id, $section_id)
    {
        $this->campus_id = $campus_id;
        $this->shift_id = $shift_id;
        $this->class_id = $class_id;
        $this->section_id = $section_id;
    }
    private $rows = 0;

    public function collection(Collection $rows)
    {
        $canImport = true;
        $user = Auth::user();
        $coordinator = Coordinator::where('user_id', $user->id)->first();
        // $school_id= $coordinator->school_id;
    
        if ($canImport) {
            foreach ($rows as $row) {
                $school_id = $coordinator->school_id;
                // $class_id = $this->getClassId($row['class'], $school_id);
                // $section_id = $this->getSectionId($row['section'], $class_id);
                $campus_id = $this->campus_id;
                $shift_id = $this->shift_id;
                $class_id = $this->class_id;
                $section_id = $this->section_id;
    
                // Check for duplicate emails
                $duplicate_email = User::where('email', $row['email'])
                    ->orWhere('email', $row['father_email'])
                    ->orWhere('email', $row['mother_email'])
                    ->orWhere('email', $row['ecp_email'])
                    ->first();
    
                if ($duplicate_email) {
                    flash(translate('Email already exists for student or parent!'))->error();
                    continue; // Skip the current row if a duplicate is found
                }
    
                // Check for duplicate phone numbers
                $duplicate_phone = User::where('phone', $row['phone'])
                    ->orWhere('phone', $row['father_contact_no'])
                    ->orWhere('phone', $row['mother_contact_no'])
                    ->orWhere('phone', $row['ecp_contact_no'])
                    ->first();
    
                if ($duplicate_phone) {
                    flash(translate('Phone number already exists for student or parent!'))->error();
                    continue; // Skip the current row if a duplicate is found
                }
    
                // Creating Student Record
                $student = new Student();
                $student->roll = $row['roll'];
                $student->school_id = $school_id;
                $student->campus_id = $campus_id?? '';
                $student->shift_id = $shift_id?? '';
                $student->class_id = $class_id;
                $student->section_id = $section_id;
    
                if ($student->save()) {
                    // Create User for Student
                    $student_user = new User();
                    $student_user->name = $row['name'];
                    $student_user->phone = $row['phone'] ?? $row['roll'];
                    $student_user->email = $row['email'];
                    $student_user->gender = $row['sex'];
                    $student_user->address = $row['address']?? '';
                    $student_user->dob = Carbon::createFromTimestamp(($row['dob'] - 25569) * 86400)->format('Y-m-d');
                    $student_user->user_type = "student";
                    $student_user->password = Hash::make('123456');
    
                    if ($student_user->save()) {
                        $userrole = new UserRole();
                        $userrole->user_id = $student_user->id;
                        $userrole->role_id = 7;
                        $student_user->assignRole(Role::findOrFail(7)->name);
                        $userrole->save();
    
                        // Email verification
                        if (get_setting('email_verification') != 1) {
                            $student_user->email_verified_at = now();
                            $student_user->save();
                        } else {
                            EmailUtility::email_verification($student_user, 'student');
                        }
    
                        // Assign user_id to student
                        $student->user_id = $student_user->id;
                        $student->save();
                    }
                }
    
                // Parent Record (Father)
                if ($row['parent_user_type'] == "Father") {
                    $parent_user_id = $this->getParentUserId($row['father_name'], $row['father_email'], $row['father_contact_no']);
                } elseif ($row['parent_user_type'] == "Mother") {
                    $parent_user_id = $this->getParentUserId($row['mother_name'], $row['mother_email'], $row['mother_contact_no']);
                } else {
                    $parent_user_id = $this->getParentUserId($row['ecp_name'], $row['ecp_email'], $row['ecp_contact_no']);
                }
    
                // Handle Father, Mother, and ECP similarly
                $this->handleParentRecord($row, $student, 'father', $row['father_name'], $row['father_email'], $row['father_contact_no']);
                $this->handleParentRecord($row, $student, 'mother', $row['mother_name'], $row['mother_email'], $row['mother_contact_no']);
                $this->handleParentRecord($row, $student, 'ecp', $row['ecp_name'], $row['ecp_email'], $row['ecp_contact_no']);
            }
    
            flash(translate('Students imported successfully'))->success();
        }
    }
    
    private function handleParentRecord($row, $student, $relationship, $parent_name, $parent_email, $parent_contact_no)
    {
        $password = '123456';
    
        // Check if a user with the same phone number or email already exists
        $existing_user = User::where('phone', $parent_contact_no)
                             ->orWhere('email', $parent_email)
                             ->first();
    
        // If the user already exists, use the existing user
        if ($existing_user) {
            $parent_user = $existing_user;
        } else {
            $parent_user = new User();
            $parent_user->name = $parent_name;
            $parent_user->phone = $parent_contact_no ?? null;
            $parent_user->email = $parent_email;
            $parent_user->user_type = "parent";
            $parent_user->password = Hash::make($password);
    
            if ($parent_user->save()) {
                // Assign roles and other logic for saving the user
                $userrole = new UserRole();
                $userrole->user_id = $parent_user->id;
                $userrole->role_id = 6;
                $parent_user->assignRole(Role::findOrFail(6)->name);
                $userrole->save();
    
                // Email verification
                if (get_setting('email_verification') != 1) {
                    $parent_user->email_verified_at = now();
                    $parent_user->save();
                } else {
                    EmailUtility::email_verification($parent_user, 'parent');
                }
            }
        }
    
        // Creating Parent record
        $parent = new Parents();
        $parent->user_id = $parent_user->id;
        $parent->profession = $row[$relationship . '_profession'] ?? 'N/A';
    
        if ($parent->save()) {
            // Creating Parent-Student relationship
            $parent_student = new ParentStudent();
            $parent_student->student_user_id = $student->user_id;
            $parent_student->parent_user_id = $parent_user->id;
            $parent_student->relationship = $relationship;
            $parent_student->save();
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
