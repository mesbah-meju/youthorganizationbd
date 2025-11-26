<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\ScheduleCollection;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::query();

        if ($request->filled('date')) {
            $query->whereDate('start_time', $request->date);
        }

        if ($request->filled('school')) {
            $query->whereHas('school', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->school . '%');
            });
        }

        if ($request->filled('class')) {
            $query->whereHas('class', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->class . '%');
            });
        }

        if ($request->filled('section')) {
            $query->whereHas('section', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->section . '%');
            });
        }

        $schedules = $query->paginate(20)->appends($request->query());
        return new ScheduleCollection($schedules);
    }
}
