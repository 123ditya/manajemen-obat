@extends('layout')

@section('title', 'Detail Pasien - Aplikasi Data Obat')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Pasien</h1>
            <p class="mt-2 text-gray-600">Informasi lengkap pasien dan riwayat kunjungan</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('pasien.edit', $pasien->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200">
                Edit
            </a>
            <a href="{{ route('pasien.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
                Kembali
            </a>
        </div>
    </div>

    <!-- Patient Information -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Pasien</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Detail lengkap pasien {{ $pasien->nama }}</p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $pasien->nama }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $pasien->alamat }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $pasien->no_telp }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $pasien->tanggal_lahir->format('d/m/Y') }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $pasien->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                            {{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Visit History -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Riwayat Kunjungan</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Daftar kunjungan dan resep pasien</p>
        </div>
        <div class="overflow-x-auto">
            @if($pasien->kunjungan->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resep</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pasien->kunjungan as $kunjungan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $kunjungan->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($kunjungan->keluhan, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($kunjungan->diagnosa, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if($kunjungan->resep)
                                <a href="{{ route('resep.show', $kunjungan->resep->id) }}" class="text-blue-600 hover:text-blue-900">
                                    Lihat Resep
                                </a>
                            @else
                                <span class="text-gray-500">Tidak ada resep</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="px-6 py-4 text-center text-sm text-gray-500">
                Belum ada riwayat kunjungan
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 