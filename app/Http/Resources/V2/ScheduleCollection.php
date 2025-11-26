<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ScheduleCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'school' => $data->school ? $data->school->name : null,
                    'shift' => $data->shift ? $data->shift->name : null,
                    'class' => $data->class ? $data->class->name : null,
                    'section' => $data->section ? $data->section->name : null,
                    'doctor' => $data->doctor?->user?->name ?? null,
                    'date' => date('d-m-Y', strtotime($data->date)),
                    'total_students' => $data->schedule_details()->count(),
                    'school_logo' => null
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
