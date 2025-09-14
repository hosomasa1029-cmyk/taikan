<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Stat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'period_type' => 'required|in:week,month,year',
            'start_date' => 'required|date',
        ]);

        $stats = Stat::where('user_id', Auth::id())
            ->where('period_type', $request->period_type)
            ->where('start_date', '>=', $request->start_date)
            ->orderBy('start_date')
            ->get();

        return response()->json($stats);
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'period_type' => 'required|in:week,month,year',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $records = Record::where('user_id', Auth::id())
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->get();

        $stat = Stat::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'period_type' => $request->period_type,
                'start_date' => $request->start_date,
            ],
            [
                'end_date' => $request->end_date,
                'avg_weight' => $records->avg('weight'),
                'total_steps' => $records->sum('steps'),
                'avg_steps' => $records->avg('steps'),
                'total_calories' => $records->sum('calories'),
                'avg_calories' => $records->avg('calories'),
            ]
        );

        return response()->json($stat);
    }
}
