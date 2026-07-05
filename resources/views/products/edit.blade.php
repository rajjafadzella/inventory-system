<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Barang: ') }} {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT') <div>
                        <x-input-label for="code" :value="__('Kode Barang')" />
                        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" value="{{ old('code', $product->code) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('code')" />
                    </div>

                    <div>
                        <x-input-label for="name" :value="__('Nama Barang')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $product->name) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="category_id" :value="__('Kategori')" />
                        <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="stock" :value="__('Stok')" />
                            <x-text-input id="stock" name="stock" type="number" min="0" class="mt-1 block w-full" value="{{ old('stock', $product->stock) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('stock')" />
                        </div>
                        <div>
                            <x-input-label for="location" :value="__('Lokasi Penyimpanan')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" value="{{ old('location', $product->location) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="condition" :value="__('Kondisi Barang')" />
                        <select id="condition" name="condition" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="Bagus" {{ old('condition', $product->condition) == 'Bagus' ? 'selected' : '' }}>Bagus</option>
                            <option value="Rusak Ringan" {{ old('condition', $product->condition) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ old('condition', $product->condition) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('condition')" />
                    </div>

                    <div>
                        <x-input-label for="image" :value="__('Foto Barang')" />
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Preview" class="w-32 h-32 object-cover rounded shadow">
                                <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                            </div>
                        @endif
                        <input id="image" name="image" type="file" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-gray-200 hover:file:bg-gray-600" />
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('products.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm rounded-md transition">
                            Perbarui Barang
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>