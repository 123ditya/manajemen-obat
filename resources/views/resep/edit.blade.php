@extends('layout')

@section('title', 'Edit Resep - Aplikasi Data Obat')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Resep</h1>
            <p class="mt-2 text-gray-600">Perbarui resep obat</p>
        </div>
        <a href="{{ route('resep.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('resep.update', $resep->id) }}" method="POST" id="resepForm">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Obat</h3>
                        <div id="obatList" class="space-y-4">
                            @foreach($resep->resepObat as $index => $resepObat)
                            <div class="obat-item border rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Pilih Obat</label>
                                        <select name="obat_ids[]" class="obat-select mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                            <option value="">Pilih obat</option>
                                            @foreach($obat as $o)
                                                <option value="{{ $o->id }}" data-harga="{{ $o->harga }}" data-kandungan="{{ $o->kandungan }}" data-stok="{{ $o->stok }}" {{ $resepObat->obat_id == $o->id ? 'selected' : '' }}>
                                                    {{ $o->nama_obat }} (Stok: {{ $o->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                        <input type="number" name="jumlah[]" class="jumlah-input mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" min="1" value="{{ $resepObat->jumlah }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Harga Satuan</label>
                                        <input type="text" class="harga-satuan mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm bg-gray-50 sm:text-sm" value="Rp {{ number_format($resepObat->harga_satuan, 0, ',', '.') }}" data-harga="{{ $resepObat->harga_satuan }}" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                                        <input type="text" class="subtotal mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm bg-gray-50 sm:text-sm" value="Rp {{ number_format($resepObat->jumlah * $resepObat->harga_satuan, 0, ',', '.') }}" readonly>
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" class="hapus-obat bg-red-600 text-white px-3 py-2 rounded-md hover:bg-red-700 transition duration-200 text-sm">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <span class="text-sm text-gray-500 kandungan-text">{{ $resepObat->obat->kandungan }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" id="tambahObat" class="mt-4 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200">
                            + Tambah Obat
                        </button>
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-900">Total Harga:</span>
                            <span class="text-lg font-bold text-blue-600" id="totalHarga">Rp {{ number_format($resep->resepObat->sum(function($ro) { return $ro->jumlah * $ro->harga_satuan; }), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('resep.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        Update Resep
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle obat selection
    $(document).on('change', '.obat-select', function() {
        const item = $(this).closest('.obat-item');
        const option = $(this).find('option:selected');
        const harga = parseFloat(option.data('harga')) || 0;
        const kandungan = option.data('kandungan') || '';
        const stok = parseInt(option.data('stok')) || 0;
        
        // Store harga as data attribute for easier access
        item.find('.harga-satuan').attr('data-harga', harga);
        item.find('.harga-satuan').val('Rp ' + new Intl.NumberFormat('id-ID').format(harga));
        item.find('.kandungan-text').text(kandungan);
        
        // Update jumlah input max value
        item.find('.jumlah-input').attr('max', stok);
        
        calculateSubtotal(item);
    });

    // Handle jumlah input change
    $(document).on('input', '.jumlah-input', function() {
        calculateSubtotal($(this).closest('.obat-item'));
    });

    // Calculate subtotal for an item
    function calculateSubtotal(item) {
        const harga = parseFloat(item.find('.harga-satuan').attr('data-harga')) || 0;
        const jumlah = parseInt(item.find('.jumlah-input').val()) || 0;
        const subtotal = harga * jumlah;
        
        item.find('.subtotal').val('Rp ' + new Intl.NumberFormat('id-ID').format(subtotal));
        calculateTotal();
    }

    // Calculate total
    function calculateTotal() {
        let total = 0;
        $('.subtotal').each(function() {
            const subtotalText = $(this).val();
            const subtotal = parseFloat(subtotalText.replace(/[^\d]/g, '')) || 0;
            total += subtotal;
        });
        
        $('#totalHarga').text('Rp ' + new Intl.NumberFormat('id-ID').format(total));
    }

    // Add new obat item
    $('#tambahObat').click(function() {
        const obatItem = $('.obat-item').first().clone();
        obatItem.find('select, input').val('');
        obatItem.find('.kandungan-text').text('');
        obatItem.find('.harga-satuan').removeAttr('data-harga');
        $('#obatList').append(obatItem);
    });

    // Remove obat item
    $(document).on('click', '.hapus-obat', function() {
        if ($('.obat-item').length > 1) {
            $(this).closest('.obat-item').remove();
            calculateTotal();
        }
    });

    // Hide remove button for first item initially
    $('.obat-item').first().find('.hapus-obat').hide();
    
    // Show/hide remove buttons based on number of items
    $(document).on('click', '#tambahObat', function() {
        if ($('.obat-item').length > 1) {
            $('.hapus-obat').show();
        }
    });
});
</script>
@endpush
@endsection 