<?php

namespace App\Livewire;

use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();
        $user = Auth::user();

        \Log::info('Dashboard render - User:', ['user_id' => $user->id]);

        // 今日のデータを取得
        $todayRecord = Record::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        // 過去7日間のデータを取得
        $weeklyRecords = Record::where('user_id', $user->id)
            ->where('date', '>=', $today->copy()->subDays(6))
            ->orderBy('date')
            ->get();

        \Log::info('Weekly Records:', ['count' => $weeklyRecords->count(), 'records' => $weeklyRecords->toArray()]);

        // グラフ用のデータを整形
        $labels = [];
        $weights = [];
        $steps = [];
        $calories = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $record = $weeklyRecords->first(function ($record) use ($date) {
                return $record->date->startOfDay()->equalTo($date->startOfDay());
            });

            $labels[] = $date->format('n/j');
            $weights[] = $record ? $record->weight : null;
            $steps[] = $record ? $record->steps : null;
            $calories[] = $record ? $record->calories : null;
        }

        \Log::info('Graph Data:', [
            'labels' => $labels,
            'weights' => $weights,
            'steps' => $steps,
            'calories' => $calories,
        ]);

        return view('livewire.dashboard', [
            'todayRecord' => $todayRecord,
            'labels' => $labels,
            'weights' => $weights,
            'steps' => $steps,
            'calories' => $calories,
        ]);
    }
}
