<?php

namespace App\Models;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Student::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'dob',
            'age',
            'sex',
            'school_id',
            'class_id',
            'section_id',
            'roll',
            'home_address',
            'parent_user_type',
            'father_name',
            'father_age',
            'father_profession',
            'father_email',
            'father_contact_no',
            'mother_name',
            'mother_age',
            'mother_profession',
            'mother_email',
            'mother_contact_no',
            'ecp_name',
            'ecp_relationship',
            'ecp_email',
            'ecp_contact_no',
            'family_income_range',
        ];
    }

    /**
    * @var Product $student
    */
    public function map($student): array
    {
        return [
            $student->name,
            $student->dob,
            $student->age,
            $student->sex,
            $student->school_id,
            $student->class_id,
            $student->section_id,
            $student->roll,
            $student->home_address,
            $student->parent_user_type,
            $student->father_name,
            $student->father_age,
            $student->father_profession,
            $student->father_email,
            $student->father_contact_no,
            $student->mother_name,
            $student->mother_age,
            $student->mother_profession,
            $student->mother_email,
            $student->mother_contact_no,
            $student->ecp_name,
            $student->ecp_relationship,
            $student->ecp_email,
            $student->ecp_contact_no,
            $student->family_income_range,
        ];
    }
}
