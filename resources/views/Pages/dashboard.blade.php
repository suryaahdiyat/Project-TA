<x-layout>
    <div class="p-3">
        <div class="flex items-center justify-between gap-2 px-2 py-3">

            <h1 class="mb-4 text-2xl font-bold">Statistik Pernikahan pada tahun {{ $year }} di KUA Anjir Pasar
            </h1>
            {{-- <form method="GET" class="flex items-center justify-end w-1/2 gap-2">
                <label for="year">Pilih Tahun:</label>
                <select name="year" id="year" onchange="this.form.submit()"
                    class="px-3 py-2 border rounded bg-secondary text-primary">
                    @foreach (range(now()->year, now()->year - 5) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="year" value="{{ request('year') }}" placeholder="Cari tahun..."
                    class="w-1/2 px-3 py-2 border border-gray-300 rounded">
            </form> --}}

            <form method="GET" onsubmit="return disableOtherInput()" class="flex items-center justify-end w-1/2 gap-2">
                <label>Pilih Tahun:</label>

                <select name="year" id="yearSelect" onchange="disableInputField()"
                    class="px-3 py-2 border rounded bg-secondary text-primary">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach (range(now()->year, now()->year - 5) as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="year" id="yearInput" value="{{ request('year') }}"
                    placeholder="Cari tahun..." class="w-1/2 px-3 py-2 border border-gray-300 rounded">
            </form>


        </div>

        <div class="grid grid-cols-2 gap-4 mb-6 text-primary">
            <div class="p-4 rounded shadow bg-secondary">
                <h2 class="mb-2 font-semibold text-primary">Distribusi Usia Mempelai</h2>
                <div class="flex items-center justify-between ">
                    <div class="w-full h-64 pb-10 ">
                        <h2 class="font-semibold">Pria usia Rata-rata : {{ round($averageGroomAge) }} tahun</h2>
                        <canvas id="groomChart" class="w-full h-full"></canvas>
                    </div>
                    <div class="w-full h-64 pb-10 ">
                        <h2 class="font-semibold">Wanita usia Rata-rata : {{ round($averageBrideAge) }} tahun</h2>
                        <canvas id="brideChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
            <div class="p-4 rounded shadow bg-secondary">
                <h2 class="mb-2 font-semibold text-primary">Kewarganegaan Mempelai</h2>
                <div class="flex items-center justify-between ">
                    <div class="w-full h-64 pb-10 ">
                        <h2 class="font-semibold">Pria</h2>
                        <canvas id="groomNationalityChart" class="w-full h-full"></canvas>
                    </div>
                    <div class="w-full h-64 pb-10 ">
                        <h2 class="font-semibold">Wanita</h2>
                        <canvas id="brideNationalityChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <div class="grid grid-cols-2 gap-4">

            <div class="p-4 rounded shadow bg-secondary text-primary">
                <h2 class="mb-2 font-semibold">Grafik Jumlah Pernikahan per Tahun</h2>
                <canvas id="yearlyMarriageChart"></canvas>
            </div>
            <div class="p-4 rounded shadow bg-secondary text-primary">
                <h2 class="mb-2 font-semibold">Grafik Jumlah Pernikahan per Bulan</h2>
                <canvas id="marriageChart"></canvas>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        function disableInputField() {
            const select = document.getElementById('yearSelect');
            const input = document.getElementById('yearInput');
            const form = select.form;

            if (select.value) {
                input.disabled = true;
            } else {
                input.disabled = false;
            }

            form.submit();
        }

        function disableOtherInput() {
            const select = document.getElementById('yearSelect');
            const input = document.getElementById('yearInput');

            if (select.value) {
                input.disabled = true;
            } else if (input.value.trim() !== '') {
                select.disabled = true;
            }

            return true; // biar tetap disubmit
        }
    </script>
    <script>
        const ctx = document.getElementById('marriageChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode([
                    'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember',
                ]) !!},
                datasets: [{
                    label: 'Jumlah Pernikahan per Bulan',
                    data: {!! json_encode($monthlyMarriages->values()) !!},
                    backgroundColor: "#fffedd"
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#fffedd'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#fffedd'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#fffedd',
                            callback: function(value) {
                                return Number.isInteger(value) ? value : '';
                            },
                            stepSize: 1,
                            beginAtZero: true
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const ctx2 = document.getElementById('yearlyMarriageChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: {!! json_encode($yearlyMarriages->keys()) !!}, // Tahun: [2023, 2024, 2025]
                datasets: [{
                    label: 'Jumlah Pernikahan per Tahun',
                    data: {!! json_encode($yearlyMarriages->values()) !!}, // [12, 0, 9]
                    backgroundColor: " #fffedd",
                    pointBorderColor: "#fffedd",
                    borderColor: "#fffedd",
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: "#fffedd"
                        }
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            color: "#fffedd"
                        }
                    },
                    y: {
                        stacked: true,
                        ticks: {
                            color: "#fffedd",
                            precision: 0,
                            beginAtZero: true
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const groomChartCtx = document.getElementById('groomChart').getContext('2d');

        new Chart(groomChartCtx, {
            type: 'pie',
            data: {
                labels: ['Kurang dari 18', 'Lebih dari 18'],
                datasets: [{
                    data: [{{ $groomUnder18 }}, {{ $groom18AndAbove }}],
                    // backgroundColor: ["#3A2449", "#fffedd"],
                    backgroundColor: ["#ff5f3b", "#2596be"],
                    // backgroundColor: ["#ffdddd", "#dddeff"],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#fffedd'
                        }
                    },
                    datalabels: {
                        color: '#fffedd',
                        font: {
                            weight: 'thin'
                        },
                        formatter: (value, context) => {
                            const data = context.chart.data.datasets[0].data;
                            const total = data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return percentage + '%';
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // ⬅️ Daftarkan plugin di sini
        });

        const brideChartCtx = document.getElementById('brideChart').getContext('2d');

        new Chart(brideChartCtx, {
            type: 'pie',
            data: {
                labels: ['Kurang dari 18', 'Lebih dari 18'],
                datasets: [{
                    data: [{{ $brideUnder18 }}, {{ $bride18AndAbove }}],
                    // backgroundColor: ["#3A2449", "#fffedd"],
                    backgroundColor: ["#ff5f3b", "#2596be"],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#fffedd'
                        }
                    },
                    datalabels: {
                        color: '#fffedd',
                        font: {
                            weight: 'thin'
                        },
                        formatter: (value, context) => {
                            const data = context.chart.data.datasets[0].data;
                            const total = data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return percentage + '%';
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // ⬅️ Daftarkan plugin di sini
        });
    </script>

    <script>
        const groomNationalityChart = document.getElementById('groomNationalityChart').getContext('2d');

        new Chart(groomNationalityChart, {
            type: 'pie', // bisa diganti 'bar' jika ingin diagram batang
            data: {
                labels: {!! json_encode(array_keys($groomNationalities->toArray())) !!},
                datasets: [{
                    data: {!! json_encode(array_values($groomNationalities->toArray())) !!},
                    backgroundColor: [
                        '#ff5f3b', '#2596be', '#a855f7', '#22c55e', '#facc15', '#ef4444'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#fffedd'
                        }
                    },
                    datalabels: {
                        color: '#fffedd',
                        formatter: (value, context) => {
                            const data = context.chart.data.datasets[0].data;
                            const total = data.reduce((a, b) => a + b, 0) || 1;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return percentage + '%';
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
        const brideNationalityChart = document.getElementById('brideNationalityChart').getContext('2d');

        new Chart(brideNationalityChart, {
            type: 'pie', // bisa diganti 'bar' jika ingin diagram batang
            data: {
                labels: {!! json_encode(array_keys($brideNationalities->toArray())) !!},
                datasets: [{
                    data: {!! json_encode(array_values($brideNationalities->toArray())) !!},
                    backgroundColor: [
                        '#ff5f3b', '#2596be', '#a855f7', '#22c55e', '#facc15', '#ef4444'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#fffedd'
                        }
                    },
                    datalabels: {
                        color: '#fffedd',
                        formatter: (value, context) => {
                            const data = context.chart.data.datasets[0].data;
                            const total = data.reduce((a, b) => a + b, 0) || 1;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return percentage + '%';
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>

</x-layout>
