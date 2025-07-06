<section class="mt-5">
    <h2 class="h5 font-weight-bold mb-3">
        {{ __('Delete Account') }}
    </h2>

    <p class="text-muted mb-4">
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>

    <!-- Trigger button (open modal) -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal">
        {{ __('Delete Account') }}
    </button>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">
                            {{ __('Are you sure you want to delete your account?') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
                        <p class="mt-2">{{ __('Please enter your password to confirm.') }}</p>

                        <div class="form-group mt-3">
                            <label for="password" class="sr-only">{{ __('Password') }}</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                placeholder="{{ __('Password') }}"
                                required
                            />
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
