<section>
    <h2 class="h5 font-weight-bold mb-3">
        {{ __('Profile Information') }}
    </h2>

    <p class="text-muted mb-4">
        {{ __("Update your account's profile information and email address.") }}
    </p>

    {{-- Form untuk kirim ulang email verifikasi --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Form utama update profile --}}
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group mb-3">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email">{{ __('Email') }}</label>
            <input id="email" name="email" type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', Auth::user()->email) }}" required autocomplete="username" />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                <div class="alert alert-warning mt-3">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" class="btn btn-link btn-sm p-0 m-0 align-baseline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success mt-2">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </div>
                @endif
            @endif
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success ml-3">{{ __('Saved.') }}</span>
            @endif
        </div>
    </form>
</section>
