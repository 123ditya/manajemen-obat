@extends('layout')

@section('title', 'Buat Resep Baru - Aplikasi Data Obat')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Buat Resep Baru</h1>
            <p class="mt-2 text-gray-600">Pilih kunjungan dan tambahkan obat ke resep</p>
        </div>
        <a href="{{ route('resep.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('resep.store') }}" method="POST" id="resepForm">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="kunjungan_id" class="block text-sm font-medium text-gray-700">Pilih Kunjungan</label>
                        <select name="kunjungan_id" id="kunjungan_id" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Pilih kunjungan</option>
                            @foreach($kunjungan as $k)
                                <option value="{{ $k->id }}" {{ request('kunjungan_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->pasien->nama }} - {{ $k->tanggal_kunjungan->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Obat</h3>
                        <div id="obatList" class="space-y-4">
                            <div class="obat-item border rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Pilih Obat</label>
                                        <select name="obat_ids[]" class="obat-select mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                            <option value="">Pilih obat</option>
                                            @foreach($obat as $o)
                                                <option value="{{ $o->id }}" data-harga="{{ $o->harga }}" data-kandungan="{{ $o->kandungan }}" data-stok="{{ $o->stok }}">
                                                    {{ $o->nama_obat }} (Stok: {{ $o->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                        <input type="number" name="jumlah[]" class="jumlah-input mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" min="1" required>
                                    </div>
                                    
                                </div>
                                <div class="mt-2">
                                    <span class="text-sm text-gray-500 kandungan-text"></span>
                                </div>
                            </div>
                        </div>
                         <div id="obatList" class="space-y-4">
                            <div class="obat-item border rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tambah Obat</label>
                                        <select name="obat_ids[]" class="obat-select mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                            <option value="">Pilih obat</option>
                                            @foreach($obat as $o)
                                                <option value="{{ $o->id }}" data-harga="{{ $o->harga }}" data-kandungan="{{ $o->kandungan }}" data-stok="{{ $o->stok }}">
                                                    {{ $o->nama_obat }} (Stok: {{ $o->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                        <input type="number" name="jumlah[]" class="jumlah-input mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" min="1" required>
                                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('resep.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        Simpan Resep
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    console.log('Resep script loaded');
    
    // Handle obat selection
    $(document).on('change', '.obat-select', function() {
        console.log('Obat selected');
        const item = $(this).closest('.obat-item');
        const option = $(this).find('option:selected');
        const harga = parseFloat(option.data('harga')) || 0;
        const kandungan = option.data('kandungan') || '';
        const stok = parseInt(option.data('stok')) || 0;
        
        console.log('Harga:', harga, 'Kandungan:', kandungan, 'Stok:', stok);
        
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
        console.log('Jumlah changed');
        calculateSubtotal($(this).closest('.obat-item'));
    });

    // Calculate subtotal for an item
    function calculateSubtotal(item) {
        const harga = parseFloat(item.find('.harga-satuan').attr('data-harga')) || 0;
        const jumlah = parseInt(item.find('.jumlah-input').val()) || 0;
        const subtotal = harga * jumlah;
        
        console.log('Calculating subtotal:', harga, '*', jumlah, '=', subtotal);
        
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
        
        console.log('Total calculated:', total);
        $('#totalHarga').text('Rp ' + new Intl.NumberFormat('id-ID').format(total));
    }

    // Add new obat item
    $('#tambahObat').on('click', function() {
        console.log('Tambah obat clicked');
        
        // Get all available obat options from the first select
        const firstSelect = $('.obat-select').first();
        const availableObat = [];
        
        firstSelect.find('option').each(function() {
            const value = $(this).val();
            const text = $(this).text();
            const harga = $(this).data('harga');
            const kandungan = $(this).data('kandungan');
            const stok = $(this).data('stok');
            
            if (value && text !== 'Pilih obat') {
                availableObat.push({
                    value: value,
                    text: text,
                    harga: harga,
                    kandungan: kandungan,
                    stok: stok
                });
            }
        });
        
        console.log('Available obat:', availableObat);
        
        // Get currently selected obat IDs
        const selectedObatIds = [];
        $('.obat-select').each(function() {
            const selectedValue = $(this).val();
            if (selectedValue) {
                selectedObatIds.push(selectedValue);
            }
        });
        
        console.log('Currently selected obat IDs:', selectedObatIds);
        
        // Find obat that haven't been selected yet
        const unselectedObat = availableObat.filter(obat => !selectedObatIds.includes(obat.value));
        
        console.log('Unselected obat:', unselectedObat);
        
        if (unselectedObat.length === 0) {
            alert('Semua obat sudah ditambahkan ke resep!');
            return;
        }
        
        // Add the first unselected obat
        const obatToAdd = unselectedObat[0];
        
        // Clone the first item
        const firstItem = $('.obat-item').first();
        const newItem = firstItem.clone();
        
        // Set the obat value
        newItem.find('select').val(obatToAdd.value);
        newItem.find('input').val('');
        newItem.find('.kandungan-text').text(obatToAdd.kandungan);
        newItem.find('.harga-satuan').attr('data-harga', obatToAdd.harga);
        newItem.find('.harga-satuan').val('Rp ' + new Intl.NumberFormat('id-ID').format(obatToAdd.harga));
        newItem.find('.jumlah-input').attr('max', obatToAdd.stok);
        
        // Add to list
        $('#obatList').append(newItem);
        
        // Show remove buttons if more than 1 item
        if ($('.obat-item').length > 1) {
            $('.hapus-obat').show();
        }
        
        console.log('New item added with obat:', obatToAdd.text, 'Total items:', $('.obat-item').length);
        
        // Update button text to show remaining count
        updateTambahObatButton();
    });
    
    // Update button text to show remaining obat count
    function updateTambahObatButton() {
        const firstSelect = $('.obat-select').first();
        const availableObat = [];
        
        firstSelect.find('option').each(function() {
            const value = $(this).val();
            if (value && $(this).text() !== 'Pilih obat') {
                availableObat.push(value);
            }
        });
        
        const selectedObatIds = [];
        $('.obat-select').each(function() {
            const selectedValue = $(this).val();
            if (selectedValue) {
                selectedObatIds.push(selectedValue);
            }
        });
        
        const remainingCount = availableObat.length - selectedObatIds.length;
        
        if (remainingCount > 0) {
            $('#tambahObat').text(`+ Tambah Obat (${remainingCount} tersisa)`);
        } else {
            $('#tambahObat').text('+ Tambah Obat (Semua sudah ditambahkan)');
            $('#tambahObat').prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
        }
    }

    // Remove obat item
    $(document).on('click', '.hapus-obat', function() {
        console.log('Hapus obat clicked');
        if ($('.obat-item').length > 1) {
            $(this).closest('.obat-item').remove();
            calculateTotal();
            
            // Hide remove button if only 1 item left
            if ($('.obat-item').length === 1) {
                $('.hapus-obat').hide();
            }
            
            // Update button text after removing item
            updateTambahObatButton();
        }
    });

    // Hide remove button for first item initially
    $('.obat-item').first().find('.hapus-obat').hide();
    
    // Initialize button text
    updateTambahObatButton();
    
    console.log('Script initialization complete');
});
</script>
@endpush
@endsection 