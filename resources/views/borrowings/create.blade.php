<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Peminjaman Barang Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('borrowings.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="user_id" :value="__('Nama Peminjam (User)')" />
                        <select id="user_id" name="user_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Pilih Anggota/Karyawan --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->role->name }})</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                    </div>

                    <div>
                        <x-input-label for="product_id" :value="__('Barang yang Dipinjam')" />
                        <select id="product_id" name="product_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->code }} - {{ $product->name }} (Stok Tersedia: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('product_id')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="qty" :value="__('Jumlah Pinjam (Qty)')" />
                            <x-text-input id="qty" name="qty" type="number" min="1" class="mt-1 block w-full" value="{{ old('qty', 1) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                        </div>
                        <div>
                            <x-input-label for="borrow_date" :value="__('Tanggal Pinjam')" />
                            <x-text-input id="borrow_date" name="borrow_date" type="date" class="mt-1 block w-full" value="{{ old('borrow_date', date('Y-m-d')) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('borrow_date')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('borrowings.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-md transition">
                            Simpan Peminjaman
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>