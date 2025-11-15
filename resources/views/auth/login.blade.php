<x-guest-layout>
    <div class="card shadow-lg auth-card">
        <div class="card-body p-5">
            <!-- Logo/Header -->
            <div class="text-center mb-4">
                <i class="bi bi-graph-up-arrow text-primary" style="font-size: 3rem;"></i>
                <h2 class="mt-3">CRM Platform</h2>
                <p class="text-muted">Sign in to your account</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               placeholder="admin@crmplatform.test">
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="Enter your password">
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Sign In
                    </button>
                </div>

                <!-- Forgot Password Link -->
                @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="text-muted">
                            <small>Forgot your password?</small>
                        </a>
                    </div>
                @endif
            </form>

            <!-- Demo Credentials -->
            <div class="alert alert-info mt-4" role="alert">
                <strong>Demo Credentials:</strong><br>
                <small>Email: admin@crmplatform.test<br>
                Password: password</small>
            </div>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="text-center mt-3">
                    <p class="text-muted mb-0">
                        <small>Don't have an account? <a href="{{ route('register') }}">Sign up</a></small>
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
