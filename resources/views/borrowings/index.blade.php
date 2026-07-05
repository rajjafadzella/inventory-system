<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Peminjaman Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded dark:bg-green-900 dark:border-green-700 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('borrowings.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition duration-150">
                        + Tambah Peminjaman
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 normal-case bg-gray-50 dark:bg-gray-700 dark:text-gray-400 font-semibold tracking-wide">
                            <tr>
                                <th class="px-6 py-3">Nama Peminjam</th>
                                <th class="px-6 py-3">Barang</th>
                                <th class="px-6 py-3">Jumlah (Qty)</th>
                                <th class="px-6 py-3">Tanggal Pinjam</th>
                                <th class="px-6 py-3">Tanggal Kembali</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($borrowings as $borrowing)
                                @foreach ($borrowing->details as $detail)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $borrowing->user->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="block font-semibold text-gray-700 dark:text-gray-300">{{ $detail->product->name }}</span>
                                            <span class="text-xs text-gray-400">{{ $detail->product->code }}</span>
                                        </td>
                                        <td class="px-6 py-4">{{ $detail->qty }}</td>
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            {{ $borrowing->return_date ? \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs rounded font-semibold 
                                                {{ $borrowing->status == 'Dipinjam' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                                {{ $borrowing->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($borrowing->status == 'Dipinjam')
                                                <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" onsubmit="return confirm('Apakah barang ini benar-or-benar sudah dikembalikan?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-semibold transition">
                                                        Proses Kembali
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500 text-xs">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat transaksi peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>