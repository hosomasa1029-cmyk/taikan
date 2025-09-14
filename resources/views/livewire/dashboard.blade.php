<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- 今日のデータ -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">今日の記録</h2>

            @if ($todayRecord)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- 体重 -->
                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-weight">
                        <div class="text-sm text-gray-600">体重</div>
                        <div class="text-2xl font-bold text-weight">
                            {{ number_format($todayRecord->weight, 1) }} <span class="text-base">kg</span>
                        </div>
                    </div>

                    <!-- 歩数 -->
                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-steps">
                        <div class="text-sm text-gray-600">歩数</div>
                        <div class="text-2xl font-bold text-steps">
                            {{ number_format($todayRecord->steps) }} <span class="text-base">歩</span>
                        </div>
                    </div>

                    <!-- カロリー -->
                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-calories">
                        <div class="text-sm text-gray-600">カロリー</div>
                        <div class="text-2xl font-bold text-calories">
                            {{ number_format($todayRecord->calories) }} <span class="text-base">kcal</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <p class="text-gray-600 mb-4">今日のデータがまだ登録されていません</p>
                    <a href="{{ route('records.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-plus mr-2"></i>記録を登録する
                    </a>
                </div>
            @endif
        </div>

        <!-- グラフ -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">過去7日間の推移</h2>

            <div class="relative" style="height: 300px;">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('グラフデータ:', {
                labels: @json($labels),
                weights: @json($weights),
                steps: @json($steps),
                calories: @json($calories)
            });
            const ctx = document.getElementById('weeklyChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                            label: '体重 (kg)',
                            data: @json($weights),
                            borderColor: '#ff4444',
                            backgroundColor: '#ff444420',
                            tension: 0.4
                        },
                        {
                            label: '歩数',
                            data: @json($steps),
                            borderColor: '#ff8800',
                            backgroundColor: '#ff880020',
                            tension: 0.4,
                            yAxisID: 'steps'
                        },
                        {
                            label: 'カロリー (kcal)',
                            data: @json($calories),
                            borderColor: '#88cc00',
                            backgroundColor: '#88cc0020',
                            tension: 0.4,
                            yAxisID: 'calories'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            min: 80,
                            max: 100,
                            title: {
                                display: true,
                                text: '体重 (kg)'
                            }
                        },
                        steps: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: '歩数'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        },
                        calories: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'カロリー (kcal)'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endpush
