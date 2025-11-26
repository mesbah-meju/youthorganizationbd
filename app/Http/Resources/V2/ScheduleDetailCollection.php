<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Student_survey;

class ScheduleDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                $last_screening_date = Student_survey::where('student_id', $data->student_id)
                    ->where('status', 'Approved')
                    ->orderBy('screening_date', 'desc')
                    ->value('screening_date');
                return [
                    'student_id' => $data->student_id,
                    'name' => $data->student->user->name,
                    'roll' => $data->student->roll,
                    'shift' => $data->student->shift ? $data->student->shift->name : null,
                    'class' => $data->student->class ? $data->student->class->name : null,
                    'section' => $data->student->section ? $data->student->section->name : null,
                    'status' => $data->status,
                    'image' => null,
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
