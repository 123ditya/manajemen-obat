

<?php $__env->startSection('title', 'Tambah Obat Baru - Aplikasi Data Obat'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Obat Baru</h1>
            <p class="mt-2 text-gray-600">Masukkan informasi obat yang akan ditambahkan</p>
        </div>
        <a href="<?php echo e(route('obat.index')); ?>" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="<?php echo e(route('obat.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="nama_obat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
                        <input type="text" name="nama_obat" id="nama_obat" required
                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                               value="<?php echo e(old('nama_obat')); ?>" placeholder="Masukkan nama obat">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="kandungan" class="block text-sm font-medium text-gray-700">Kandungan</label>
                        <textarea name="kandungan" id="kandungan" rows="4" required
                                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                  placeholder="Masukkan kandungan obat"><?php echo e(old('kandungan')); ?></textarea>
                    </div>

                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga" id="harga" required min="0" step="100"
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md"
                                   value="<?php echo e(old('harga')); ?>" placeholder="0">
                        </div>
                    </div>

                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stok" id="stok" required min="0"
                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                               value="<?php echo e(old('stok')); ?>" placeholder="0">
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="<?php echo e(route('obat.index')); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        Simpan Obat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Msi-Modern\Aplikasi Data Obat\manajemen-obat\resources\views/obat/create.blade.php ENDPATH**/ ?>