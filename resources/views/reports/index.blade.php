<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight print:hidden">
            {{ __('Laporan Peminjaman Aset Telkomsel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 print:hidden">
                <form method="GET" action="{{ route('reports.index') }}" class="flex flex-col md:flex-row items-end gap-4">
                    <div>
                        <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" value="{{ request('start_date') }}" />
                    </div>
                    <div>
                        <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                        <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" value="{{ request('end_date') }}" />
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="px-4 py-2 bg-gray-800 dark:bg-gray-200 dark:text-gray-800 text-white rounded-md font-semibold text-sm hover:bg-gray-700 transition">
                            Filter
                        </button>
                        <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md font-semibold text-sm hover:bg-gray-600 transition text-center">
                            Reset
                        </a>
                        <a href="{{ route('reports.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-semibold text-sm transition text-center">
                            Export Excel
                        </a>
                        <button type="button" onclick="window.print()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-semibold text-sm transition">
                            Cetak PDF
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 print:p-0 print:shadow-none print:bg-transparent">
                <div class="hidden print:block text-center mb-8 border-b-2 border-gray-800 pb-4">
                    <h1 class="text-2xl font-bold text-gray-900">PT TELKOMSEL INDONESIA</h1>
                    <p class="text-sm text-gray-600">Laporan Sirkulasi Peminjaman Dan Distribusi Barang Inventaris Aset</p>
                    @if($startDate && $endDate)
                        <p class="text-xs text-gray-500 mt-1">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                    @endif
                </div>

                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 print:hidden">Data Transaksi Terkini</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border print:text-black print:border-black">
                        <thead class="text-xs text-gray-700 normal-case bg-gray-50 dark:bg-gray-700 dark:text-gray-400 print:bg-gray-200 font-semibold tracking-wide">
                            <tr>
                                <th class="px-6 py-3 border">Peminjam</th>
                                <th class="px-6 py-3 border">Kode Barang</th>
                                <th class="px-6 py-3 border">Nama Barang</th>
                                <th class="px-6 py-3 border">Qty</th>
                                <th class="px-6 py-3 border">Tgl Pinjam</th>
                                <th class="px-6 py-3 border">Tgl Kembali</th>
                                <th class="px-6 py-3 border">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $borrowing)
                                @foreach($borrowing->details as $detail)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 print:border-black">
                                        <td class="px-6 py-4 border font-medium text-gray-900 dark:text-white print:text-black">{{ $borrowing->user->name }}</td>
                                        <td class="px-6 py-4 border font-mono">{{ $detail->product->code }}</td>
                                        <td class="px-6 py-4 border">{{ $detail->product->name }}</td>
                                        <td class="px-6 py-4 border text-center">{{ $detail->qty }}</td>
                                        <td class="px-6 py-4 border">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 border">{{ $borrowing->return_date ? \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') : '-' }}</td>
                                        <td class="px-6 py-4 border">
                                            <span class="print:text-black font-semibold">{{ $borrowing->status }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data laporan yang sesuai filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>