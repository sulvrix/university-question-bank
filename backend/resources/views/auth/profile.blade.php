@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        @if (!$user->hasVerifiedEmail())
            <div class="alert alert-warning mt-3">
                Your email address is not verified. Please check your inbox for a verification email.
                If you didn't receive the email, <a href="{{ route('verification.resend') }}"
                    onclick="event.preventDefault(); document.getElementById('resend-verification-form').submit();">click
                    here to resend it</a>.
            </div>

            <!-- Hidden form to resend the verification email -->
            <form id="resend-verification-form" action="{{ route('verification.resend') }}" method="POST" class="d-none">
                @csrf
            </form>
        @endif
        <div class="card p-4">
            <h2 class="mb-4">Edit Profile</h2>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                        required>
                    @if ($errors->has('name'))
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}"
                        required>
                    @if ($errors->has('username'))
                        <div class="text-danger">{{ $errors->first('username') }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                            required>
                        @if (!$user->hasVerifiedEmail())
                            <span class="input-group-text text-danger" data-bs-toggle="tooltip"
                                title="This email is not verified">
                                <i class="bi bi-exclamation-circle-fill"></i> <!-- Bootstrap Icons -->
                            </span>
                        @else
                            <span class="input-group-text text-success" data-bs-toggle="tooltip"
                                title="This email is verified">
                                <i class="bi bi-check-circle-fill"></i> <!-- Bootstrap Icons -->
                            </span>
                        @endif
                    </div>
                    @if ($errors->has('email'))
                        <div class="text-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Password:</label>
                    <br>
                    @if ($user->hasVerifiedEmail())
                        <a href="{{ route('password.request') }}" class="btn btn-link">Change Password</a>
                    @else
                        <span data-bs-toggle="tooltip" title="You have to verify your email first">
                            <a href="" class="btn btn-link disabled">Change Password</a>
                        </span>
                    @endif
                </div>

                <div class="d-flex align-items-center justify-content-center gap-3">
                    <a class="btn btn-secondary" href="{{ url('/dashboard') }}" role="button">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                var tooltip = new bootstrap.Tooltip(tooltipTriggerEl);
                tooltipTriggerEl.addEventListener('inserted.bs.tooltip', function() {
                    var tooltipInner = document.querySelector('.tooltip-inner');
                    if (tooltipInner) {
                        tooltipInner.style.whiteSpace = 'nowrap';
                        tooltipInner.style.maxWidth = 'none';
                    }
                });
                return tooltip;
            });
        });
    </script>
@endsection
