@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 480px; padding-top: 40px;">

    @if(session('failed'))
        <div class="flash-msg flash-danger mb-4">{{ session('failed') }}</div>
    @endif

    <div class="filter-card" style="padding: 36px 40px;">

        <!-- Title -->
        <div style="margin-bottom: 28px;">
            <div style="font-family:'Syne',sans-serif; font-weight:800; font-size:1.4rem;
                        letter-spacing:-0.5px; color:var(--text);">Change Password</div>
            <div style="font-size:0.75rem; color:var(--muted); margin-top:4px;">
                Update your account password below
            </div>
        </div>

        <form method="POST" action="{{ route('admin-password.update') }}">
            @csrf

            <!-- Current Password -->
            <div style="margin-bottom: 18px;">
                <label class="filter-label">Current Password</label>
                <input id="current_password" type="password"
                    class="form-control @error('current_password') is-invalid @enderror"
                    name="current_password"
                    placeholder="••••••••"
                    required autocomplete="current-password">
                @error('current_password')
                    <span style="font-size:0.72rem; color:var(--danger); margin-top:5px; display:block;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- New Password -->
            <div style="margin-bottom: 18px;">
                <label class="filter-label">New Password</label>
                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="••••••••"
                    required autocomplete="new-password">
                @error('password')
                    <span style="font-size:0.72rem; color:var(--danger); margin-top:5px; display:block;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div style="margin-bottom: 28px;">
                <label class="filter-label">Confirm New Password</label>
                <input id="password-confirm" type="password"
                    class="form-control"
                    name="password_confirmation"
                    placeholder="••••••••"
                    required autocomplete="new-password">
            </div>

            <button type="submit" class="btn-filter w-100" style="padding: 11px;">
                Update Password
            </button>
        </form>
    </div>
</div>

<style>
    .flash-msg {
        font-family: 'Syne', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 12px 18px;
        border-radius: 8px;
        border: 1px solid transparent;
    }
    .flash-danger {
        background: rgba(247,92,110,0.1);
        border-color: rgba(247,92,110,0.25);
        color: var(--danger);
    }
    .form-control.is-invalid {
        border-color: var(--danger) !important;
        box-shadow: 0 0 0 3px rgba(247,92,110,0.15) !important;
    }
    .invalid-feedback { display: none; }
</style>

@endsection

