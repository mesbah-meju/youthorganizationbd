<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id'        => $data->user->id,
                    'name'      => $data->user->name,
                    'photo'     => uploaded_asset($data->user->avatar_original),
                    'roll'      => $data->roll,
                    'school'    => $data->school->name,
                    'campus'    => $data->campus->name,
                    'shift'     => $data->shift->name,
                    'class'     => $data->class->name,
                    'section'   => $data->section->name,
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
