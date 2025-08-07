<section class="mt-5">
    <h2 class="h5 font-weight-bold mb-3">
        <?php echo e(__('Delete Account')); ?>

    </h2>

    <p class="text-muted mb-4">
        <?php echo e(__('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.')); ?>

    </p>

    <!-- Trigger button (open modal) -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal">
        <?php echo e(__('Delete Account')); ?>

    </button>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="<?php echo e(route('profile.destroy')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('delete'); ?>

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">
                            <?php echo e(__('Are you sure you want to delete your account?')); ?>

                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo e(__('Close')); ?>">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p><?php echo e(__('Once your account is deleted, all of its resources and data will be permanently deleted.')); ?></p>
                        <p class="mt-2"><?php echo e(__('Please enter your password to confirm.')); ?></p>

                        <div class="form-group mt-3">
                            <label for="password" class="sr-only"><?php echo e(__('Password')); ?></label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control <?php $__errorArgs = ['password', 'userDeletion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="<?php echo e(__('Password')); ?>"
                                required
                            />
                            <?php $__errorArgs = ['password', 'userDeletion'];
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
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                        <button type="submit" class="btn btn-danger"><?php echo e(__('Delete Account')); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/profile/partials/delete-user-form.blade.php ENDPATH**/ ?>