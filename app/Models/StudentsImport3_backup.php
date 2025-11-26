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
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class StudentsImport3 implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
    protected $campus_id;
    protected $shift_id;
    protected $class_id;
    protected $section_id;
    protected $session_id;

    public function __construct($campus_id, $shift_id, $class_id, $section_id, $session_id)
    {
        $this->campus_id = $campus_id;
        $this->shift_id = $shift_id;
        $this->class_id = $class_id;
        $this->section_id = $section_id;
        $this->session_id = $session_id;
    }
    private $rows = 0;

    public function collection(Collection $rows)
    {
        $canImport = true;
        $currentSession = get_current_session();
        $session_id = $currentSession->id;
        
        $school_id = Session::get('school_id');
        
        if ($canImport) {
            foreach ($rows as $row) {
                // Fetch necessary values
                $school_id = Session::get('school_id');
                $campus_id = $this->campus_id ?? '';
                $shift_id = $this->shift_id ?? '';
                $class_id = $this->class_id;
                $section_id = $this->section_id;
    
                // Check for duplicate emails
                if (User::where('email', $row['user_email'])->exists()) {
                    flash(translate('Email already exists for parent!'))->error();
                    continue;
                }
    
                // Check for duplicate phone numbers
                if (User::where('phone', $row['user_contact_no'])->exists()) {
                    flash(translate('Phone number already exists for student or parent!'))->error();
                    continue;
                }
    
                // Creating Student Record
                $student = new Student();
                $student->roll = $row['roll'];
                $student->school_id = $school_id;
                $student->campus_id = $campus_id;
                $student->shift_id = $shift_id;
                $student->class_id = $class_id;
                $student->section_id = $section_id;
                $student->session_id = $session_id;
        
                if ($student->save()) {
                    // Create User for Student
                    $student_user = new User();
                    $student_user->name = $row['name'];
                    $student_user->gender = $row['sex'];
                    $student_user->address = $row['address'] ?? '';
                    $student_user->dob = Carbon::createFromTimestamp(($row['dob'] - 25569) * 86400)->format('Y-m-d');
                    $student_user->user_type = "student";
                    $student_user->password = Hash::make('123456');
        
                    if ($student_user->save()) {
                        $student_user->assignRole(Role::findOrFail(7)->name); // Assuming role ID 7 for 'student'
        
                        // Assign user_id to student
                        $student->user_id = $student_user->id;
                        $student->save();
                    }
                }
    
                // Handle Parent Record (Father, Mother, ECP)
                $primary_user_type = $row['primary_user'] ?? 'father'; // Default to 'father' if not set
                $this->handleParentRecord($row, $student, $primary_user_type);
            }
    
            flash(translate('Students imported successfully'))->success();
        }
    }
    
    private function handleParentRecord($row, $student, $relationship)
    {
        $parent_name = $row['user_name'];
        $parent_email = $row['user_email'];
        $parent_contact_no = $row['user_contact_no'];
        
        $parent_user_id = $this->getParentUserId($parent_name, $parent_email, $parent_contact_no);
        
        // Creating Parent-Student relationship only if the parent user is new (to avoid duplicates)
        $parent_user = User::find($parent_user_id);
        // Check if the parent already exists in the 'Parents' table
        $exist_parent_user = Parents::where('user_id', $parent_user_id)->first();

        if(!$exist_parent_user){
            $parent = new Parents();
            $parent->user_id = $parent_user->id;
            $parent->save();
        }

        if ($parent_user) {
            $parent_student = new ParentStudent();
            $parent_student->student_user_id = $student->user_id;
            $parent_student->parent_user_id = $parent_user->id;
            $parent_student->relationship = $relationship;
            $parent_student->save();
        }
    }
    
    public function getParentUserId($name, $email, $phone)
    {
        // Check if a user with the same phone number or email already exists
        $existing_user = User::where('phone', $phone)
            ->orWhere('email', $email)
            ->first();
    
        // If the user already exists, return the user ID
        if ($existing_user) {
            return $existing_user->id;
        }
    
        // If no existing user, create a new one
        if(!$existing_user) {
                $user = new User();
                $user->user_type = 'parent';
                $user->name = $name;
                $user->phone = $phone;
                $user->email = $email;
                $user->password = bcrypt('123456');
                $user->verification_code = rand(100000, 999999);
                $user->save();
            
                $user->assignRole(Role::findOrFail(6)->name); 

                if (get_setting('email_verification') != 1) {
                    $user->email_verified_at = now();
                    $user->save();
                } else {
                    EmailUtility::email_verification($user, 'parent');
                }
            
                return $user->id;
         }else{
                $user = User::where('phone', $phone)
                    ->orWhere('email', $email)
                    ->first();
                return $user->id;
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
            'name' => ['required', 'string'], 
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

}
