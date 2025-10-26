<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Danh sách Sản phẩm</h1>
        <a href="<?php echo e(route('admin.san_pham.create')); ?>" class="btn btn-success">Thêm mới</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Giá</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Loại sản phẩm</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <th scope="row"><?php echo e($item->id); ?></th>
                    <td><?php echo e($item->name); ?></td>
                    <td><?php echo e(number_format($item->gia)); ?> VND</td>
                    <td><?php echo e($item->so_luong_con); ?></td>
                    <td><?php echo e($item->loaiSanPham->name ?? 'N/A'); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.san_pham.edit', $item)); ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="<?php echo e(route('admin.san_pham.destroy', $item)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">Không có sản phẩm nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    
    <?php echo e($data->links()); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HOCTAP\Nam_4_1\MaNguonMo\DoAn\DoAnMaNguonMo\resources\views/admin/san_pham/index.blade.php ENDPATH**/ ?>