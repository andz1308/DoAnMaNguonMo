

<?php $__env->startSection('content'); ?>
    <h1>Thêm mới Sản phẩm</h1>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.san_pham.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>">
        </div>
        <div class="mb-3">
            <label for="gia" class="form-label">Giá</label>
            <input type="number" class="form-control" id="gia" name="gia" step="0.01" value="<?php echo e(old('gia')); ?>"> 
        </div>
        <div class="mb-3">
            <label for="gioi_thieu" class="form-label">Giới thiệu</label>
            <textarea class="form-control" id="gioi_thieu" name="gioi_thieu" rows="3"><?php echo e(old('gioi_thieu')); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả chi tiết</label>
            <textarea class="form-control" id="mo_ta" name="mo_ta" rows="5"><?php echo e(old('mo_ta')); ?></textarea>
        </div>
        <!-- <div class="mb-3">
                <label for="MoTa" class="form-label">Mô tả chi tiết</label>
                
                <textarea class="form-control" id="mo_ta" name="mo_ta"
                    rows="10"><?php echo e(old('mo_ta', $sanPham->MoTa ?? '')); ?></textarea>
            </div> -->
        <div class="mb-3">
            <label for="thuong_hieu" class="form-label">Thương hiệu</label>
            <input type="text" class="form-control" id="thuong_hieu" name="thuong_hieu" value="<?php echo e(old('thuong_hieu')); ?>">
        </div>
        <div class="mb-3">
            <label for="man_hinh" class="form-label">Màn hình</label>
            <input type="text" class="form-control" id="man_hinh" name="man_hinh" value="<?php echo e(old('man_hinh')); ?>">
        </div>
        <div class="mb-3">
            <label for="do_phan_giai" class="form-label">Độ phân giải</label>
            <input type="text" class="form-control" id="do_phan_giai" name="do_phan_giai" value="<?php echo e(old('do_phan_giai')); ?>">
        </div>
        <div class="mb-3">
            <label for="camera" class="form-label">Camera</label>
            <input type="text" class="form-control" id="camera" name="camera" value="<?php echo e(old('camera')); ?>">
        </div>
        <div class="mb-3">
            <label for="cpu" class="form-label">CPU</label>
            <input type="text" class="form-control" id="cpu" name="cpu" value="<?php echo e(old('cpu')); ?>">
        </div>
        <div class="mb-3">
            <label for="pin" class="form-label">Pin</label>
            <input type="text" class="form-control" id="pin" name="pin" value="<?php echo e(old('pin')); ?>">
        </div>
        <div class="mb-3">
            <label for="ngay_phat_hanh" class="form-label">Ngày phát hành</label>
            <input type="date" class="form-control" id="ngay_phat_hanh" name="ngay_phat_hanh"
                value="<?php echo e(old('ngay_phat_hanh')); ?>">
        </div>
        <div class="mb-3">
            <label for="dung_luong" class="form-label">Dung lượng</label>
            <input type="text" class="form-control" id="dung_luong" name="dung_luong" value="<?php echo e(old('dung_luong')); ?>">
        </div>
        <div class="mb-3">
            <label for="kich_thuoc" class="form-label">Kích thước</label>
            <input type="text" class="form-control" id="kich_thuoc" name="kich_thuoc" value="<?php echo e(old('kich_thuoc')); ?>">
        </div>
        <div class="mb-3">
            <label for="trong_luong" class="form-label">Trọng lượng</label>
            <input type="text" class="form-control" id="trong_luong" name="trong_luong" value="<?php echo e(old('trong_luong')); ?>">
        </div>
        <div class="mb-3">
            <label for="so_luong_con" class="form-label">Số lượng còn</label>
            <input type="number" class="form-control" id="so_luong_con" name="so_luong_con"
                value="<?php echo e(old('so_luong_con')); ?>">
        </div>
        <div class="mb-3">
            <label for="loai_san_pham_id" class="form-label">Loại sản phẩm</label>
            <select class="form-select" id="loai_san_pham_id" name="loai_san_pham_id">
                <option selected disabled>-- Chọn loại sản phẩm --</option>
                <?php $__currentLoopData = $loaiSanPhams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <option value="<?php echo e($loai->id); ?>"><?php echo e($loai->name); ?></option>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="HinhAnh" class="form-label">Hình ảnh (Có thể chọn nhiều ảnh)</label>
            
            <input class="form-control" type="file" id="HinhAnh" name="HinhAnh[]" multiple>
        </div>

        
        

        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="<?php echo e(route('admin.san_pham.index')); ?>" class="btn btn-secondary">Quay lại</a>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HOCTAP\Nam_4_1\MaNguonMo\DoAn\DoAnMaNguonMo\resources\views/admin/san_pham/create.blade.php ENDPATH**/ ?>