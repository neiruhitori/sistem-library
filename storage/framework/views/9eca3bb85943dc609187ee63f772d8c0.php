<section class="mt-5">
    <h2 class="h5 font-weight-bold mb-3">
        <?php echo e(__('Update Password')); ?>

    </h2>

    <p class="text-muted mb-4">
        <?php echo e(__('Ensure your account is using a long, random password to stay secure.')); ?>

    </p>

    <form method="POST" action="<?php echo e(route('password.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>

        <div class="form-group mb-3">
            <label for="update_password_current_password"><?php echo e(__('Current Password')); ?></label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="form-control <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                autocomplete="current-password"
            />
            <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback">
                    <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group mb-3">
            <label for="update_password_password"><?php echo e(__('New Password')); ?></label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                class="form-control <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                autocomplete="new-password"
            />
            <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback">
                    <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group mb-3">
            <label for="update_password_password_confirmation"><?php echo e(__('Confirm Password')); ?></label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control <?php $__errorArgs = ['password_confirmation', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                autocomplete="new-password"
            />
            <?php $__errorArgs = ['password_confirmation', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback">
                    <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Save')); ?>

            </button>

            <?php if(session('status') === 'password-updated'): ?>
                <span class="text-success ml-3"><?php echo e(__('Saved.')); ?></span>
            <?php endif; ?>
        </div>
    </form>
</section>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/profile/partials/update-password-form.blade.php ENDPATH**/ ?>