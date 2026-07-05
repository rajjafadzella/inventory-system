<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Sistem Inventaris PT Telkomsel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Jenis Barang</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalProducts }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Unit Barang Dipinjam</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalBorrowed }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori Barang Tersedia</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalAvailable }}</div>
                </div>

            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Grafik Tren Peminjaman per Bulan ({{ date('Y') }})</h3>
                <div class="w-full relative" style="height: 350px;">
                    <canvas id="borrowingChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('borrowingChart').getContext('2d');
        const isDarkMode = document.documentElement.classList.contains('dark');

        new Chart(ctx, {
            type: 'bar', // Menggunakan grafik batang profesional
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Transaksi Peminjaman',
                    data: @json($chartData),
                    backgroundColor: 'rgba(59, 130, 246, 0.7)', // Warna biru semi transparan
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: isDarkMode ? '#9ca3af' : '#4b5563' // Menyesuaikan warna teks legenda
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: isDarkMode ? '#9ca3af' : '#4b5563'
                        },
                        grid: {
                            color: isDarkMode ? 'rgba(75, 85, 99, 0.2)' : 'rgba(229, 231, 235, 1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: isDarkMode ? '#9ca3af' : '#4b5563'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>