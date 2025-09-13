<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $records = Record::where('user_id', Auth::id())
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->orderBy('date')
            ->get();

        return response()->json($records);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'weight' => 'nullable|numeric|min:20|max:200',
            'steps' => 'nullable|integer|min:0|max:100000',
            'calories' => 'nullable|integer|min:0|max:10000',
        ]);

        $record = Record::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'date' => $request->date,
            ],
            [
                'weight' => $request->weight,
                'steps' => $request->steps,
                'calories' => $request->calories,
            ]
        );

        return response()->json($record);
    }

    public function show($date)
    {
        $record = Record::where('user_id', Auth::id())
            ->where('date', $date)
            ->firstOrFail();

        return response()->json($record);
    }

    public function destroy($date)
    {
        $record = Record::where('user_id', Auth::id())
            ->where('date', $date)
            ->firstOrFail();

        $record->delete();

        return response()->json(['message' => '記録を削除しました']);
    }
}
