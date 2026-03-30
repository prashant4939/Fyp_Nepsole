

<?php $__env->startSection('title', 'Add Category - Admin'); ?>
<?php $__env->startSection('panel-name', 'Admin Panel'); ?>
<?php $__env->startSection('page-title', 'Add New Category'); ?>
<?php $__env->startSection('navbar-color', '#6366f1'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
<?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h2>Add New Category</h2>
    <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-secondary">← Back to Categories</a>
</div>

<div class="form-card">
    <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        
        <div class="form-group">
            <label for="name">Category Name <span class="required">*</span></label>
            <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="image">Category Image</label>
            <div id="imagePreview" style="display: none; margin-bottom: 1rem;">
                <img id="preview" src="" alt="Preview" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;">
                <p style="font-size: 12px; color: #6b7280; margin-top: 0.5rem;">Image Preview</p>
            </div>
            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
            <small>Accepted formats: JPG, JPEG, PNG (Max: 2MB)</small>
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create Category</button>
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-header h2 {
    color: #1f2937;
    font-size: 24px;
}

.btn {
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: #6366f1;
    color: white;
}

.btn-primary:hover {
    background: #4f46e5;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

.form-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    color: #374151;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.required {
    color: #ef4444;
}

.form-group input[type="text"],
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #6366f1;
}

.form-group small {
    display: block;
    color: #6b7280;
    font-size: 12px;
    margin-top: 0.25rem;
}

.error-message {
    color: #ef4444;
    font-size: 12px;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}
</style>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\Fyp_Nepsole\Fyp_Nepsole\resources\views/admin/categories/create.blade.php ENDPATH**/ ?>