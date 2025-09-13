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

    private function getWeeklyData($dateRange, $records)
    {
        return $dateRange->map(function ($date) use ($records) {
            $formattedDate = Carbon::parse($date)->format('n/j');
            $record = $records->get($date);

            return [
                'label' => $formattedDate,
                'weight' => $record ? $record->weight : null,
                'steps' => $record ? $record->steps : null,
                'calories' => $record ? $record->calories : null,
            ];
        });
    }

    private function getMonthlyData($start, $end, $records)
    {
        $data = collect();
        $current = $start->copy()->startOfWeek();

        while ($current <= $end) {
            $weekKey = $current->format('Y-m-d');
            $weekRecords = $records[$weekKey] ?? collect();

            if (is_array($weekRecords)) {
                $weekRecords = collect($weekRecords);
            }

            if ($weekRecords->isNotEmpty()) {
                $data->push([
                    'label' => $current->format('n/j') . '週',
                    'weight' => round($weekRecords->avg('weight'), 1),
                    'steps' => round($weekRecords->avg('steps')),
                    'calories' => round($weekRecords->avg('calories')),
                ]);
            }

            $current->addWeek();
        }

        return $data;
    }

    private function getYearlyData($start, $end, $records)
    {
        $data = collect();
        $current = $start->copy()->startOfMonth();

        while ($current <= $end) {
            $monthKey = $current->format('Y-m');
            $monthRecords = $records[$monthKey] ?? collect();

            if (is_array($monthRecords)) {
                $monthRecords = collect($monthRecords);
            }

            if ($monthRecords->isNotEmpty()) {
                $data->push([
                    'label' => $current->format('n') . '月',
                    'weight' => round($monthRecords->avg('weight'), 1),
                    'steps' => round($monthRecords->avg('steps')),
                    'calories' => round($monthRecords->avg('calories')),
                ]);
            }

            $current->addMonth();
        }

        return $data;
    }

    public function render()
    {
        $user = Auth::user();

        // 日付の範囲を生成（今日までに制限）
        $start = Carbon::parse($this->startDate);
        $end = min(Carbon::parse($this->endDate), Carbon::now());
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
            ->get();

        // 期間に応じてデータをグループ化
        $records = match ($this->period) {
            'week' => $records->keyBy(function ($record) {
                return $record->date->format('Y-m-d');
            }),
            'month' => $records->groupBy(function ($record) {
                return $record->date->startOfWeek()->format('Y-m-d');
            }),
            'year' => $records->groupBy(function ($record) {
                return $record->date->format('Y-m');
            }),
        };

        // 統計データの計算（期間に応じて集計）
        $flatRecords = $records instanceof \Illuminate\Support\Collection
            ? ($records->first() instanceof \Illuminate\Support\Collection ? $records->flatten() : $records)
            : collect($records)->flatten();

        $stats = [
            'weight' => [
                'min' => $flatRecords->min('weight'),
                'max' => $flatRecords->max('weight'),
                'avg' => round($flatRecords->avg('weight'), 1),
            ],
            'steps' => [
                'total' => $flatRecords->sum('steps'),
                'avg' => round($flatRecords->avg('steps')),
            ],
            'calories' => [
                'total' => $flatRecords->sum('calories'),
                'avg' => round($flatRecords->avg('calories')),
            ],
        ];

        // グラフ用のデータを整形
        $graphData = match ($this->period) {
            'week' => $this->getWeeklyData($dateRange, $records),
            'month' => $this->getMonthlyData($start, $end, $records),
            'year' => $this->getYearlyData($start, $end, $records),
        };

        // デバッグ情報
        logger()->debug('Records:', [
            'date_range' => $dateRange->toArray(),
            'records' => $records->toArray(),
            'graph_data' => $graphData->toArray()
        ]);

        // グラフデータを配列に変換
        $graphArray = $graphData->values()->all();

        // デバッグ情報
        logger()->debug('Graph Data:', [
            'period' => $this->period,
            'data' => $graphArray
        ]);

        return view('livewire.reports', [
            'stats' => $stats,
            'labels' => collect($graphArray)->pluck('label')->values()->all(),
            'weights' => collect($graphArray)->pluck('weight')->values()->all(),
            'steps' => collect($graphArray)->pluck('steps')->values()->all(),
            'calories' => collect($graphArray)->pluck('calories')->values()->all(),
        ]);
    }
}
