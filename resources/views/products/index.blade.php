<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data Barang') }}
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
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        + Tambah Barang
                    </a>

                    <form method="GET" action="{{ route('products.index') }}" class="w-full md:w-auto flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama barang..." class="w-full md:w-64 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit" class="px-4 py-2 bg-gray-800 dark:bg-gray-200 dark:text-gray-800 text-white rounded-md font-semibold text-sm hover:bg-gray-700 dark:hover:bg-white transition">
                            Cari
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 normal-case bg-gray-50 dark:bg-gray-700 dark:text-gray-400 font-semibold tracking-wide">
                            <tr>
                                <th class="px-6 py-3">Gambar</th>
                                <th class="px-6 py-3">Kode</th>
                                <th class="px-6 py-3">Nama Barang</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Stok</th>
                                <th class="px-6 py-3">Lokasi</th>
                                <th class="px-6 py-3">Kondisi</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                                        @else
                                            <span class="text-gray-400 text-xs">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $product->code }}</td>
                                    <td class="px-6 py-4">{{ $product->name }}</td>
                                    <td class="px-6 py-4">{{ $product->category->name }}</td>
                                    <td class="px-6 py-4">{{ $product->stock }}</td>
                                    <td class="px-6 py-4">{{ $product->location }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded font-semibold 
                                            {{ $product->condition == 'Bagus' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                            {{ $product->condition == 'Rusak Ringan' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                            {{ $product->condition == 'Rusak Berat' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}">
                                            {{ $product->condition }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                                        <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">Data barang kosong.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>