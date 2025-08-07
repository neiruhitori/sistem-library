<section>
    <h2 class="h5 font-weight-bold mb-3">
        <?php echo e(__('Profile Information')); ?>

    </h2>

    <p class="text-muted mb-4">
        <?php echo e(__("Update your account's profile information and email address.")); ?>

    </p>

    
    <form id="send-verification" method="post" action="<?php echo e(route('verification.send')); ?>">
        <?php echo csrf_field(); ?>
    </form>

    
    <form method="post" action="<?php echo e(route('profile.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('patch'); ?>

        <div class="form-group mb-3">
            <label for="nip"><?php echo e(__('NIP')); ?></label>
            <input id="nip" name="nip" type="text"
                class="form-control <?php $__errorArgs = ['nip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                value="<?php echo e(old('nip', Auth::user()->nip)); ?>" required autofocus autocomplete="nip" placeholder="Nomor Induk Pegawai"/>
            <?php $__errorArgs = ['nip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group mb-3">
            <label for="name"><?php echo e(__('Name')); ?></label>
            <input id="name" name="name" type="text"
                class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                value="<?php echo e(old('name', Auth::user()->name)); ?>" required autofocus autocomplete="name" />
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group mb-3">
            <label for="email"><?php echo e(__('Email')); ?></label>
            <input id="email" name="email" type="email"
                class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                value="<?php echo e(old('email', Auth::user()->email)); ?>" required autocomplete="username" />
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <?php if(Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail()): ?>
                <div class="alert alert-warning mt-3">
                    <?php echo e(__('Your email address is unverified.')); ?>

                    <button form="send-verification" class="btn btn-link btn-sm p-0 m-0 align-baseline">
                        <?php echo e(__('Click here to re-send the verification email.')); ?>

                    </button>
                </div>

                <?php if(session('status') === 'verification-link-sent'): ?>
                    <div class="alert alert-success mt-2">
                        <?php echo e(__('A new verification link has been sent to your email address.')); ?>

                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Save')); ?>

            </button>

            <?php if(session('status') === 'profile-updated'): ?>
                <span class="text-success ml-3"><?php echo e(__('Saved.')); ?></span>
            <?php endif; ?>
        </div>
    </form>
</section>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/profile/partials/update-profile-information-form.blade.php ENDPATH**/ ?>