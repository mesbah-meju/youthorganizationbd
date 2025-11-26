<?php

namespace App\Http\Controllers\Api\V2;

use App\Notifications\AppEmailVerificationNotification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\Section;
use Illuminate\Support\Str;
use App\Http\Controllers\OTPVerificationController;

use Hash;

class SchoolController extends Controller
{
    public function enrolled_school_list(Request $request)
    {
        $enrolledList = School::where('status', 1)
            ->where('deleted_at', null)
            ->select('id', 'name')
            ->get();

        if ($enrolledList->isEmpty()) {
            return response()->json([
                'result' => false,
                'message' => translate('No enrolled schools found.'),
            ], 404);
        }

        return response()->json([
            'result' => true,
            'data' => $enrolledList,
        ], 200);
    }

    public function enrolled_school_wise_class_list(Request $request, $id)
    {
        $data = School::leftJoin('campuses', 'campuses.school_id', '=', 'schools.id')
            ->leftJoin('shifts', 'shifts.school_id', '=', 'schools.id')
            ->leftJoin('class_shifts', 'class_shifts.shift_id', '=', 'shifts.id')
            ->leftJoin('classes', 'class_shifts.class_id', '=', 'classes.id')
            ->select(
                'schools.name as school_name',
                'campuses.name as campus_name',
                'shifts.name as shift_name',
                'classes.name as class_name'
            )
            ->where('schools.id', $id)
            ->where('schools.status', 1)
            ->whereNull('schools.deleted_at')
            ->get();
    
        if ($data->isEmpty()) {
            return response()->json([
                'result' => false,
                'message' => translate('No enrolled schools, campuses, shifts, or classes found.'),
            ], 404);
        }
    
        $groupedData = $data->groupBy('school_name')->map(function ($schoolGroup) {
            return $schoolGroup->groupBy('campus_name')->map(function ($campusGroup) {
                return $campusGroup->groupBy('shift_name')->map(function ($shiftGroup) {
                    return $shiftGroup->pluck('class_name')->toArray();
                });
            });
        });
    
        return response()->json([
            'result' => true,
            'data' => $groupedData,
        ], 200);
    }

    public function enrolled_school_class_wise_section_list(Request $request)
    {
    
        $sections = Section::where('class_id', $request->class_id)
            ->where('school_id', $request->school_id)
            ->select('id', 'name') 
            ->get();
    
        if ($sections->isEmpty()) {
            return response()->json([
                'result' => false,
                'message' => translate('No sections found for the selected class and school.'),
            ], 404);
        }
    
        return response()->json([
            'result' => true,
            'data' => $sections,
        ], 200);
    }
}
