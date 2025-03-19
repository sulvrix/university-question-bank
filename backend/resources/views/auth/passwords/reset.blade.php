@extends('layouts.app')

@section('content')
    <div class="form-section vh-100 d-flex justify-content-center align-items-center" id="reset-password">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-header bg-gradient-primary text-white text-center py-4">
                            <h3 class="card-title mb-0">{{ __('Reset Password') }}</h3>
                            <p class="mt-2">Enter your email and new password to reset your password.</p>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="mb-4 input-group">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    <span class="input-group-text" id="inputGroup-sizing-default addon-wrapping">
                                        <i class="bi bi-eye-fill password-eye"></i>
                                        <i class="bi bi-eye-slash-fill password-eye-closed"></i>
                                    </span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- Confirm Password Field -->
                                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                <div class="mb-4 input-group">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                    <span class="input-group-text" id="inputGroup-sizing-default addon-wrapping">
                                        <i class="bi bi-eye-fill password-confirm-eye"></i>
                                        <i class="bi bi-eye-slash-fill password-confirm-eye-closed"></i>
                                    </span>
                                </div>
                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-gradient-primary btn-lg">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .bi-eye-fill {
            display: block;
        }

        .bi-eye-slash-fill {
            display: none;
        }

        .bi-eye-fill,
        .bi-eye-slash-fill {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: white;
        }

        .input-group-text {
            padding: .375rem 1.5em !important;
            background: var(--accent-gradient)
        }
    </style>
    <script>
        const password1 = document.getElementById('password');
        const password2 = document.getElementById('password-confirm');
        const eye1 = document.querySelector('.password-eye');
        const eyeSlash1 = document.querySelector('.password-eye-closed');
        const eye2 = document.querySelector('.password-confirm-eye');
        const eyeSlash2 = document.querySelector('.password-confirm-eye-closed');


        eye1.addEventListener('click', () => {
            eye1.style.display = 'none';
            eyeSlash1.style.display = 'block';
            password1.setAttribute('type', 'text');
        });

        eyeSlash1.addEventListener('click', () => {
            eyeSlash1.style.display = 'none';
            eye1.style.display = 'block';
            password1.setAttribute('type', 'password');
        });

        eye2.addEventListener('click', () => {
            eye2.style.display = 'none';
            eyeSlash2.style.display = 'block';
            password2.setAttribute('type', 'text');
        });

        eyeSlash2.addEventListener('click', () => {
            eyeSlash2.style.display = 'none';
            eye2.style.display = 'block';
            password2.setAttribute('type', 'password');
        });
    </script>
@endsection
