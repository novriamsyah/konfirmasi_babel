@extends('layouts.auth.app')
@push('css')
    <style>
        @keyframes tada {
    from {
        transform: scale3d(1, 1, 1);
    }
    10%, 20% {
        transform: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
    }
    30%, 50%, 70%, 90% {
        transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg);
    }
    40%, 60%, 80% {
        transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg);
    }
    to {
        transform: scale3d(1, 1, 1);
    }
    }

    .tada {
    animation: tada 1s;
    }
    </style>
@endpush
@section('content')
<div class="authentication-inner row">
    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-7 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/logos/babel.webp') }}" alt="auth-login-cover" class="img-fluid my-5 auth-illustration" />
            
        </div>
    </div>
    <!-- /Left Text -->

    <!-- Login -->
    <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
            <!-- Logo -->
            <!-- <div class="app-brand mb-4">
                <a href="index.html" class="app-brand-link gap-2">
                    <span class="app-brand-logo demo">
                        <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0" />
                            <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                            <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0" />
                        </svg>
                    </span>
                </a>
            </div> -->
            <!-- /Logo -->
            <h3 class="mb-1">Selamat Datang! 👋</h3>
            <p class="mb-4">Mohon login untuk mengakses dashboard</p>
            @if (Session::has('gagal_login'))
            <div class="alert alert-danger tada_anime" role="alert">
                {{Session::get('gagal_login')}}
            </div>
            @endif                                  
            <form id="formAuthentication" class="mb-3" action="{{ route('post.login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" autofocus />
                    @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Password</label>
                        <a href="#">
                            <small>Forgot Password?</small>
                        </a>
                    </div>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember-me" />
                        <label class="form-check-label" for="remember-me"> Remember Me </label>
                    </div>
                </div>
                <button class="btn btn-primary d-grid w-100">Sign in</button>
            </form>

            
        </div>
    </div>
    <!-- /Login -->
</div>
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        let alertElement = document.querySelector('.tada_anime');

        if (alertElement) {
            alertElement.classList.add('tada');

            setTimeout(function() {
            alertElement.classList.remove('tada');
            }, 1000); // Remove tada class after 1 second

            setTimeout(function() {
            alertElement.style.display = 'none';
            }, 6000); // Hide the alert after 4 seconds
        }
        });
    </script>
@endpush