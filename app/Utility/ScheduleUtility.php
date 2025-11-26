<?php

namespace App\Utility;

use App\Models\ProductStock;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\Models\BusinessSetting;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class ScheduleUtility
{
    public static function student_search($request_data): object
    {
        $school_id = Session::get('school_id');

        $schedule_settings = BusinessSetting::where('type', 'schedule_settings')->value('value');
        $schedule_duration = ($schedule_settings == 1) ? BusinessSetting::where('type', 'schedule_duration')->value('value') ?? 0 : 0;

        $threshold_date = now()->subDays($schedule_duration)->format('Y-m-d');

        $students = Student::where('school_id', $school_id)->where('is_current_school', 1)->orderBy('id', 'asc')
            ->whereNotIn('user_id', function ($query) {
                $query->select('student_id')
                    ->from('schedule_details');
            })
            ->when($schedule_settings == 1, function ($query) use ($threshold_date) {
                $query->whereNotIn('id', function ($subQuery) use ($threshold_date) {
                    $subQuery->select('student_id')
                        ->from('student_surveys')
                        ->where('status', 'Approved')
                        ->whereDate('screening_date', '>=', $threshold_date);
                });
            });

        // $students = Student::where('school_id', $school_id)
        //     ->where('is_current_school', 1)
        //     ->orderBy('id', 'asc');

        if ($request_data['campus_id'] != null) {
            $students = $students->where('students.campus_id', $request_data['campus_id']);
        }

        if ($request_data['shift_id'] != null) {
            $students = $students->where('students.shift_id', $request_data['shift_id']);
        }

        if ($request_data['class_id'] != null) {
            $students = $students->where('students.class_id', $request_data['class_id']);
        }

        if ($request_data['section_id'] != null) {
            $students = $students->where('students.section_id', $request_data['section_id']);
        }

        if ($request_data['keyword'] != null) {
            $students = $students->whereHas('user', function ($query) use ($request_data) {
                $query->where('name', 'like', '%' . $request_data['keyword'] . '%');
            });
        }

        // Exclude students who are already in schedule_details
        $students = $students->whereNotIn('students.user_id', function ($query) {
            $query->select('student_id')
                ->from('schedule_details');
        });

        return $students->paginate(16);
    }  


    public static function student_search_admin($request_data): object
    {
        // dd($request_data);
       $school_id = $request_data['school_id'] ?? Session::get('school_id');

       $schedule_settings = BusinessSetting::where('type', 'schedule_settings')->value('value');
        $schedule_duration = ($schedule_settings == 1) ? BusinessSetting::where('type', 'schedule_duration')->value('value') ?? 0 : 0;

        $threshold_date = now()->subDays($schedule_duration)->format('Y-m-d');

        $students = Student::where('school_id', $school_id)->where('is_current_school', 1)->orderBy('id', 'asc')
            ->whereNotIn('user_id', function ($query) {
                $query->select('student_id')
                    ->from('schedule_details');
            })
            ->when($schedule_settings == 1, function ($query) use ($threshold_date) {
                $query->whereNotIn('id', function ($subQuery) use ($threshold_date) {
                    $subQuery->select('student_id')
                        ->from('student_surveys')
                        ->where('status', 'Approved')
                        ->whereDate('screening_date', '>=', $threshold_date);
                });
            });

        // $students = Student::where('school_id', $school_id)
        //     ->where('is_current_school', 1)
        //     ->orderBy('id', 'asc');

        if ($request_data['campus_id'] != null) {
            $students = $students->where('students.campus_id', $request_data['campus_id']);
        }

        if ($request_data['shift_id'] != null) {
            $students = $students->where('students.shift_id', $request_data['shift_id']);
        }

        if ($request_data['class_id'] != null) {
            $students = $students->where('students.class_id', $request_data['class_id']);
        }

        if ($request_data['section_id'] != null) {
            $students = $students->where('students.section_id', $request_data['section_id']);
        }

        if ($request_data['keyword'] != null) {
            $students = $students->whereHas('user', function ($query) use ($request_data) {
                $query->where('name', 'like', '%' . $request_data['keyword'] . '%');
            });
        }

        // Exclude students who are already in schedule_details
        $students = $students->whereNotIn('students.user_id', function ($query) {
            $query->select('student_id')
                ->from('schedule_details');
        });

        return $students->paginate(16);
    }  

   
}
