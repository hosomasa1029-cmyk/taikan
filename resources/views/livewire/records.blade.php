<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <!-- カレンダー -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">{{ $monthStart->format('Y年n月') }}</h2>
                    <div class="flex space-x-2">
                        <button
                            wire:click="$set('selectedDate', '{{ $monthStart->copy()->subMonth()->format('Y-m-d') }}')"
                            class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button wire:click="$set('selectedDate', '{{ Carbon\Carbon::today()->format('Y-m-d') }}')"
                            class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">
                            今日
                        </button>
                        <button
                            wire:click="$set('selectedDate', '{{ $monthStart->copy()->addMonth()->format('Y-m-d') }}')"
                            class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-7 gap-2">
                    <!-- 曜日ヘッダー -->
                    @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
                        <div
                            class="text-center py-2 {{ $loop->first ? 'text-red-500' : ($loop->last ? 'text-blue-500' : '') }}">
                            {{ $dayOfWeek }}
                        </div>
                    @endforeach

                    <!-- 日付グリッド -->
                    @php
                        $startOfCalendar = $monthStart->copy()->startOfWeek();
                        $endOfCalendar = $monthEnd->copy()->endOfWeek();
                    @endphp

                    @while ($startOfCalendar <= $endOfCalendar)
                        @php
                            $isCurrentMonth = $startOfCalendar->month === $monthStart->month;
                            $isSelected = $startOfCalendar->format('Y-m-d') === $selectedDate;
                            $hasRecord = isset($records[$startOfCalendar->format('Y-m-d')]);
                            $isToday = $startOfCalendar->isToday();
                        @endphp

                        <button wire:click="$set('selectedDate', '{{ $startOfCalendar->format('Y-m-d') }}')"
                            class="relative p-2 text-center rounded-lg transition-colors {{ $isSelected
                                ? 'bg-indigo-100 text-indigo-700'
                                : ($isToday
                                    ? 'bg-yellow-50'
                                    : ($isCurrentMonth
                                        ? 'hover:bg-gray-100'
                                        : 'text-gray-400 hover:bg-gray-50')) }}">
                            {{ $startOfCalendar->day }}

                            @if ($hasRecord)
                                <div class="absolute bottom-1 left-1/2 transform -translate-x-1/2">
                                    <div
                                        class="w-1 h-1 rounded-full {{ $isSelected ? 'bg-indigo-500' : 'bg-gray-400' }}">
                                    </div>
                                </div>
                            @endif
                        </button>

                        @php
                            $startOfCalendar->addDay();
                        @endphp
                    @endwhile
                </div>
            </div>

            <!-- 入力フォーム -->
            <div class="max-w-xl mx-auto">
                <h3 class="text-lg font-medium mb-4">{{ Carbon\Carbon::parse($selectedDate)->format('Y年n月j日') }}の記録
                </h3>

                @if (session('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @error('selectedDate')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ $message }}
                    </div>
                @enderror

                <form wire:submit.prevent="save" class="space-y-6">
                    <!-- 体重 -->
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-weight text-weight"></i> 体重 (kg)
                        </label>
                        <div class="mt-1">
                            <input type="number" step="0.1" wire:model="weight" id="weight"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="例: 65.5">
                        </div>
                        @error('weight')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- 歩数 -->
                    <div>
                        <label for="steps" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-shoe-prints text-steps"></i> 歩数
                        </label>
                        <div class="mt-1">
                            <input type="number" wire:model="steps" id="steps"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="例: 8000">
                        </div>
                        @error('steps')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- カロリー -->
                    <div>
                        <label for="calories" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-fire text-calories"></i> カロリー (kcal)
                        </label>
                        <div class="mt-1">
                            <input type="number" wire:model="calories" id="calories"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="例: 2000">
                        </div>
                        @error('calories')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-save mr-2"></i>保存
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
