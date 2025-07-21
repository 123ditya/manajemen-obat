@extends('layout')

@section('title', 'Edit Obat - Aplikasi Data Obat')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Obat</h1>
            <p class="mt-2 text-gray-600">Perbarui informasi obat</p>
        </div>
        <a href="{{ route('obat.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="nama_obat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
                        <input type="text" name="nama_obat" id="nama_obat" required
                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                               value="{{ old('nama_obat', $obat->nama_obat) }}" placeholder="Masukkan nama obat">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="kandungan" class="block text-sm font-medium text-gray-700">Kandungan</label>
                        <textarea name="kandungan" id="kandungan" rows="4" required
                                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                  placeholder="Masukkan kandungan obat">{{ old('kandungan', $obat->kandungan) }}</textarea>
                    </div>

                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga" id="harga" required min="0" step="100"
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md"
                                   value="{{ old('harga', $obat->harga) }}" placeholder="0">
                        </div>
                    </div>

                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stok" id="stok" required min="0"
                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                               value="{{ old('stok', $obat->stok) }}" placeholder="0">
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('obat.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        Update Obat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 