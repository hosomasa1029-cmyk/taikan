<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- 期間選択 -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">期間</h2>
                <div class="flex space-x-2">
                    <button wire:click="setPeriod('week')"
                        class="px-4 py-2 rounded-md {{ $period === 'week' ? 'bg-indigo-600 text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                        週間
                    </button>
                    <button wire:click="setPeriod('month')"
                        class="px-4 py-2 rounded-md {{ $period === 'month' ? 'bg-indigo-600 text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                        月間
                    </button>
                    <button wire:click="setPeriod('year')"
                        class="px-4 py-2 rounded-md {{ $period === 'year' ? 'bg-indigo-600 text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                        年間
                    </button>
                </div>
            </div>
        </div>

        <!-- 統計情報 -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">統計情報</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- 体重 -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-weight text-weight text-xl mr-2"></i>
                        <h3 class="text-lg font-medium">体重</h3>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">最小</span>
                            <span class="font-medium">{{ $stats['weight']['min'] ?? '-' }} kg</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">最大</span>
                            <span class="font-medium">{{ $stats['weight']['max'] ?? '-' }} kg</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">平均</span>
                            <span class="font-medium">{{ $stats['weight']['avg'] ?? '-' }} kg</span>
                        </div>
                    </div>
                </div>

                <!-- 歩数 -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-shoe-prints text-steps text-xl mr-2"></i>
                        <h3 class="text-lg font-medium">歩数</h3>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">合計</span>
                            <span class="font-medium">{{ number_format($stats['steps']['total'] ?? 0) }} 歩</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">平均</span>
                            <span class="font-medium">{{ number_format($stats['steps']['avg'] ?? 0) }} 歩</span>
                        </div>
                    </div>
                </div>

                <!-- カロリー -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-fire text-calories text-xl mr-2"></i>
                        <h3 class="text-lg font-medium">カロリー</h3>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">合計</span>
                            <span class="font-medium">{{ number_format($stats['calories']['total'] ?? 0) }} kcal</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">平均</span>
                            <span class="font-medium">{{ number_format($stats['calories']['avg'] ?? 0) }} kcal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- グラフ -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">推移グラフ</h2>

            <div class="relative" style="height: 400px;">
                <canvas id="reportChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chart = null;

        function initializeChart() {
            console.log('グラフデータ:', {
                labels: @json($labels),
                weights: @json($weights),
                steps: @json($steps),
                calories: @json($calories)
            });

            const ctx = document.getElementById('reportChart').getContext('2d');
            if (chart) {
                chart.destroy();
            }

            // データの前処理
            const rawData = {
                labels: @json($labels),
                weights: @json($weights),
                steps: @json($steps),
                calories: @json($calories)
            };

            console.log('Raw data:', rawData);

            const processedData = {
                labels: rawData.labels,
                weights: rawData.weights.map(v => v === null ? 0 : parseFloat(v)),
                steps: rawData.steps.map(v => v === null ? 0 : parseInt(v)),
                calories: rawData.calories.map(v => v === null ? 0 : parseInt(v))
            };

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: processedData.labels,
                    datasets: [{
                            label: '体重 (kg)',
                            data: processedData.weights,
                            borderColor: '#ff4444',
                            backgroundColor: '#ff444420',
                            tension: 0.4
                        },
                        {
                            label: '歩数',
                            data: processedData.steps,
                            borderColor: '#ff8800',
                            backgroundColor: '#ff880020',
                            tension: 0.4,
                            yAxisID: 'steps'
                        },
                        {
                            label: 'カロリー (kcal)',
                            data: processedData.calories,
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
        }

        // 初期化時のグラフ描画
        document.addEventListener('DOMContentLoaded', initializeChart);

        // Livewireのイベントでグラフを更新
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('periodChanged', initializeChart);
        });
    </script>
@endpush
