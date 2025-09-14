<?php

namespace App\Livewire;

use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Records extends Component
{
    public $selectedDate;
    public $weight;
    public $steps;
    public $calories;

    public function mount()
    {
        $this->selectedDate = Carbon::today()->format('Y-m-d');
        $this->loadRecord();
    }

    public function loadRecord()
    {
        $record = Record::where('user_id', Auth::id())
            ->where('date', $this->selectedDate)
            ->first();

        if ($record) {
            $this->weight = $record->weight;
            $this->steps = $record->steps;
            $this->calories = $record->calories;
        } else {
            $this->weight = null;
            $this->steps = null;
            $this->calories = null;
        }
    }

    public function save()
    {
        $this->validate([
            'selectedDate' => 'required|date',
            'weight' => 'nullable|numeric|min:20|max:200',
            'steps' => 'nullable|integer|min:0|max:100000',
            'calories' => 'nullable|integer|min:0|max:10000',
        ]);

        try {
            Record::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'date' => $this->selectedDate,
                ],
                [
                    'weight' => $this->weight,
                    'steps' => $this->steps,
                    'calories' => $this->calories,
                ]
            );

            session()->flash('message', '記録を保存しました');
        } catch (\Exception $e) {
            session()->flash('error', '記録の保存に失敗しました。同じ日付のデータが既に存在する可能性があります。');
        }

        session()->flash('message', '記録を保存しました');
    }

    public function render()
    {
        $user = Auth::user();
        $monthStart = Carbon::parse($this->selectedDate)->startOfMonth();
        $monthEnd = Carbon::parse($this->selectedDate)->endOfMonth();

        $records = Record::where('user_id', $user->id)
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get()
            ->keyBy('date');

        return view('livewire.records', [
            'records' => $records,
            'monthStart' => $monthStart,
            'monthEnd' => $monthEnd,
        ]);
    }
}
