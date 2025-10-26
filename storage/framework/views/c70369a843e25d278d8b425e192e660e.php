

<?php $__env->startSection('content'); ?>
    <h1>Cập nhật Sản phẩm: <?php echo e($sanPham->name); ?></h1>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.san_pham.update', $sanPham->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?> 

        
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name', $sanPham->name)); ?>">
        </div>
        <div class="mb-3">
            <label for="gia" class="form-label">Giá</label>
            <input type="number" class="form-control" id="gia" name="gia" value="<?php echo e(old('gia', $sanPham->gia)); ?>">
        </div>
        <div class="mb-3">
            <label for="gioi_thieu" class="form-label">Giới thiệu</label>
            <textarea class="form-control" id="gioi_thieu" name="gioi_thieu"
                rows="2"><?php echo e(old('gioi_thieu', $sanPham->gioi_thieu)); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả chi tiết</label>
            <textarea class="form-control" id="mo_ta" name="mo_ta" rows="10"><?php echo e(old('mo_ta', $sanPham->mo_ta)); ?></textarea>
            
        </div>
        <div class="mb-3">
            <label for="thuong_hieu" class="form-label">Thương hiệu</label>
            <input type="text" class="form-control" id="thuong_hieu" name="thuong_hieu"
                value="<?php echo e(old('thuong_hieu', $sanPham->thuong_hieu)); ?>">
        </div>
        
        <div class="mb-3">
            <label for="so_luong_con" class="form-label">Số lượng còn</label>
            <input type="number" class="form-control" id="so_luong_con" name="so_luong_con"
                value="<?php echo e(old('so_luong_con', $sanPham->so_luong_con)); ?>">
        </div>
        <div class="mb-3">
            <label for="loai_san_pham_id" class="form-label">Loại sản phẩm</label>
            <select class="form-select" id="loai_san_pham_id" name="loai_san_pham_id">
                <?php $__currentLoopData = $loaiSanPhams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($loai->id); ?>" <?php echo e(old('loai_san_pham_id', $sanPham->loai_san_pham_id) == $loai->id ? 'selected' : ''); ?>>
                        <?php echo e($loai->name); ?> 
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <hr>

        
        
        <?php if($sanPham->images->count() > 0): ?>
            <div class="mb-3">
                <p>Ảnh hiện tại (Chọn ảnh bạn muốn xóa):</p>
                <div class="d-flex flex-wrap">
                    <?php $__currentLoopData = $sanPham->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="me-3 mb-3 text-center border p-2 rounded">
                            <img src="<?php echo e(asset('uploads/images/san_pham/' . $image->name)); ?>" 
                                 alt="Ảnh sản phẩm"
                                 class="img-thumbnail d-block mb-2"
                                 style="max-width: 100px; height: auto;">
                            <div class="form-check">
                                
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="delete_images[]" 
                                       value="<?php echo e($image->id); ?>"
                                       id="delete_image_<?php echo e($image->id); ?>">
                                <label class="form-check-label" for="delete_image_<?php echo e($image->id); ?>">
                                    Xóa ảnh này
                                </label>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="mb-3">
            <label for="HinhAnh" class="form-label">Thêm ảnh mới (Có thể chọn nhiều ảnh)</label>
            <input class="form-control" type="file" id="HinhAnh" name="HinhAnh[]" multiple>
        </div>

        


        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="<?php echo e(route('admin.san_pham.index')); ?>" class="btn btn-secondary">Quay lại</a>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    // Nếu bạn làm chức năng xóa ảnh bằng JS
    <script>
        function deleteImage(imageId) {
            if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
                // Gửi request xóa ảnh bằng AJAX hoặc form riêng
            }
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HOCTAP\Nam_4_1\MaNguonMo\DoAn\DoAnMaNguonMo\resources\views/admin/san_pham/edit.blade.php ENDPATH**/ ?>