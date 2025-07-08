<x-guest-layout>
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ asset('AdminLTE-3.2.0/index2.html') }}"><b>Reset Password</b>LTE</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You are only one step a way from your new password, recover your password now.
                </p>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="input-group mb-3">
                        <x-text-input id="email" class="form-control" type="email" name="email"
                            :value="old('email', $request->email)" required autofocus autocomplete="username" readonly/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <x-text-input id="password" class="form-control" type="password" name="password" required
                            autocomplete="new-password" placeholder="New Password"/>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <x-text-input id="password_confirmation" class="form-control" type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password"/>

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Change password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}">Login</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</x-guest-layout>
