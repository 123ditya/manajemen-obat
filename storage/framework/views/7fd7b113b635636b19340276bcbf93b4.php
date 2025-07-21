

<?php $__env->startSection('title', 'Edit Kunjungan - Aplikasi Data Obat'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Kunjungan</h1>
            <p class="mt-2 text-gray-600">Perbarui informasi kunjungan</p>
        </div>
        <a href="<?php echo e(route('kunjungan.index')); ?>" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="<?php echo e(route('kunjungan.update', $kunjungan->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="pasien_id" class="block text-sm font-medium text-gray-700">Pilih Pasien</label>
                        <select name="pasien_id" id="pasien_id" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Pilih pasien</option>
                            <?php $__currentLoopData = $pasien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->id); ?>" <?php echo e(old('pasien_id', $kunjungan->pasien_id) == $p->id ? 'selected' : ''); ?>>
                                    <?php echo e($p->nama); ?> - <?php echo e($p->no_telp); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" required
                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                               value="<?php echo e(old('tanggal_kunjungan', $kunjungan->tanggal_kunjungan->format('Y-m-d'))); ?>">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="keluhan" class="block text-sm font-medium text-gray-700">Keluhan</label>
                        <textarea name="keluhan" id="keluhan" rows="4" required
                                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                  placeholder="Masukkan keluhan pasien"><?php echo e(old('keluhan', $kunjungan->keluhan)); ?></textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="diagnosa" class="block text-sm font-medium text-gray-700">Diagnosa</label>
                        <textarea name="diagnosa" id="diagnosa" rows="4" required
                                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                  placeholder="Masukkan diagnosa"><?php echo e(old('diagnosa', $kunjungan->diagnosa)); ?></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="<?php echo e(route('kunjungan.index')); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        Update Kunjungan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Msi-Modern\Aplikasi Data Obat\manajemen-obat\resources\views/kunjungan/edit.blade.php ENDPATH**/ ?>