@extends('layouts.app')

@section('content')
    <div class="form-section vh-100 d-flex justify-content-center align-items-center" id="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-header bg-gradient-primary text-white text-center py-4">
                            <h3 class="card-title mb-0">{{ __('Login') }}</h3>
                            <p class="mt-2">Welcome back! Please log in to access your account.</p>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email / Username Field -->
                                <div class="mb-4">
                                    <label for="login" class="form-label">{{ __('Email / Username') }}</label>
                                    <input id="login" type="text"
                                        class="form-control @error('login') is-invalid @enderror" name="login"
                                        value="{{ old('login') }}" required autocomplete="login" autofocus>
                                    @error('login')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <div class="mb-4">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Remember Me Checkbox -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-gradient-primary btn-lg">
                                        {{ __('Login') }}
                                    </button>
                                </div>

                                <!-- Forgot Password Link -->
                                @if (Route::has('password.request'))
                                    <div class="text-center mt-3">
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
