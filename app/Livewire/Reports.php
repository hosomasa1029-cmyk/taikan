<?php

namespace App\Livewire;

use App\Models\Record;
use App\Models\Stat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Reports extends Component
{
    public $period = 'week';
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfWeek()->format('Y-m-d');
    }

    public function setPeriod($period)
    {
        $this->period = $period;
        $now = Carbon::now();

        switch ($period) {
            case 'week':
                $this->startDate = $now->copy()->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfWeek()->format('Y-m-d');
                break;
            case 'month':
                $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d');
                break;
            case 'year':
                $this->startDate = $now->copy()->startOfYear()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfYear()->format('Y-m-d');
                break;
        }

        $this->dispatch('periodChanged');
    }

    public function render()
    {
        $user = Auth::user();

        // 日付の範囲を生成
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        $dateRange = collect();
        $current = $start->copy();

        while ($current <= $end) {
            $dateRange->push($current->format('Y-m-d'));
            $current->addDay();
        }

        // データベースからレコードを取得
        $records = Record::query()
            ->where('user_id', $user->id)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->orderBy('date')
            ->get()
            ->keyBy(function ($record) {
                return $record->date->format('Y-m-d');
            });

        // 統計データの計算
        $stats = [
            'weight' => [
                'min' => $records->min('weight'),
                'max' => $records->max('weight'),
                'avg' => round($records->avg('weight'), 1),
            ],
            'steps' => [
                'total' => $records->sum('steps'),
                'avg' => round($records->avg('steps')),
            ],
            'calories' => [
                'total' => $records->sum('calories'),
                'avg' => round($records->avg('calories')),
            ],
        ];

        // グラフ用のデータを整形
        $graphData = $dateRange->map(function ($date) use ($records) {
            $formattedDate = Carbon::parse($date)->format('n/j');
            $record = $records->get($date);

            return [
                'label' => $formattedDate,
                'weight' => $record ? $record->weight : null,
                'steps' => $record ? $record->steps : null,
                'calories' => $record ? $record->calories : null,
            ];
        });

        // デバッグ情報
        logger()->debug('Records:', [
            'date_range' => $dateRange->toArray(),
            'records' => $records->toArray(),
            'graph_data' => $graphData->toArray()
        ]);

        return view('livewire.reports', [
            'stats' => $stats,
            'labels' => $graphData->pluck('label')->values()->all(),
            'weights' => $graphData->pluck('weight')->values()->all(),
            'steps' => $graphData->pluck('steps')->values()->all(),
            'calories' => $graphData->pluck('calories')->values()->all(),
        ]);
    }
}
