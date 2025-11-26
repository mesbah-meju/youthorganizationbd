<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Student;
use App\Models\Student_survey;
use App\Models\PrimaryScreeningAnswer;

class StudentCollection extends ResourceCollection
{
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function ($data) {
                $PrimaryScreeningAnswer = PrimaryScreeningAnswer::where('student_user_id', $data->user_id)->first();
                $last_screening_date = Student_survey::where('student_id', $data->user_id)
                    ->where('status', 'Approved')
                    ->orderBy('screening_date', 'desc')
                    ->value('screening_date');

                if ($PrimaryScreeningAnswer) {
                    $primary_screening = true;
                } else {
                    $primary_screening = false;
                }
                return [
                    'id' => $data->user_id,
                    'name' => $data->user->name,
                    'roll' => $data->roll,
                    'dob' => $data->user->dob,
                    'school' => $data->school ? $data->school->name : null,
                    'campus' => $data->campus ? $data->campus->name : null,
                    'shift' => $data->shift ? $data->shift->name : null,
                    'class' => $data->class ? $data->class->name : null,
                    'section' => $data->section ? $data->section->name : null,
                    'session' => $data->section ? $data->section->name : null,
                    'address' => $data->user->address,
                    'image' => null,
                    'primary_screening' => $primary_screening,
                    'last_screening_date' => $last_screening_date
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'result' => true,
            'status' => 200
        ];
    }
}
