@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 480px; padding-top: 40px;">

    @if(session('success'))
        <div class="flash-msg flash-success mb-4">{{ session('success') }}</div>
    @endif

    <!-- Login Card -->
    <div class="filter-card" style="padding: 36px 40px;">

        <!-- Logo + Title -->
        <div style="text-align:center; margin-bottom: 32px;">
            <img src="/logo.png" alt="Iridis Logo" style="height:48px; margin-bottom:16px; border-radius:8px;">
            <div style="font-family:'Syne',sans-serif; font-weight:800; font-size:1.5rem;
                        letter-spacing:-0.5px; color:var(--text);">Welcome back</div>
            <div style="font-size:0.75rem; color:var(--muted); margin-top:4px;">
                Sign in to Iridis Attendance
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div style="margin-bottom: 18px;">
                <label class="filter-label">Email Address</label>
                <input id="email" type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}"
                    placeholder="you@example.com"
                    required autocomplete="email" autofocus>
                @error('email')
                    <span style="font-size:0.72rem; color:var(--danger); margin-top:5px; display:block;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Password -->
            <div style="margin-bottom: 18px;">
                <label class="filter-label">Password</label>
                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="••••••••"
                    required autocomplete="current-password">
                @error('password')
                    <span style="font-size:0.72rem; color:var(--danger); margin-top:5px; display:block;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div style="margin-bottom: 28px;">
                <label class="admin-check-label">
                    <input class="admin-checkbox" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <span style="font-family:'Syne',sans-serif; font-size:0.73rem;
                                 color:var(--muted); font-weight:600;">Remember me</span>
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-filter w-100" style="padding: 11px;">
                Sign In
            </button>
        </form>
    </div>
</div>

<style>
    /* reuse flash styles from users page */
    .flash-msg {
        font-family: 'Syne', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 12px 18px;
        border-radius: 8px;
        border: 1px solid transparent;
    }
    .flash-success {
        background: rgba(34,211,165,0.1);
        border-color: rgba(34,211,165,0.25);
        color: var(--success);
    }
    .admin-check-label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }
    .admin-checkbox {
        width: 16px;
        height: 16px;
        accent-color: var(--accent);
        cursor: pointer;
    }
    /* hide Bootstrap is-invalid default red border in favour of our own */
    .form-control.is-invalid {
        border-color: var(--danger) !important;
        box-shadow: 0 0 0 3px rgba(247,92,110,0.15) !important;
    }
    .invalid-feedback { display: none; } /* replaced by custom span above */
</style>

@endsection

