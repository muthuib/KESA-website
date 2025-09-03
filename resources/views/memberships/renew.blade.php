@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            {{-- Alerts --}}
            @if(session('error'))
                <div class="alert alert-danger shadow-sm rounded-3">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success shadow-sm rounded-3">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif

            {{-- Card --}}
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-gradient bg-info text-white text-center py-4">
                    <h2 class="fw-bold mb-0">🔑 Membership Renewal</h2>
                </div>

                <div class="card-body p-5">
                    <p class="lead text-center mb-4">
                        Your membership has expired. Please renew to regain full access.
                    </p>

                    {{-- Form --}}
                    <form action="{{ route('membership.renew') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        {{-- Phone --}}
                        <div class="form-group mb-4">
                            <label for="phone" class="form-label fw-semibold">
                                📱 M-Pesa Phone Number
                            </label>
                            <input type="text"
                                   name="phone"
                                   id="phone"
                                   class="form-control form-control-lg rounded-3 @error('phone') is-invalid @enderror"
                                   placeholder="e.g. 2547XXXXXXXX"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-danger d-block mt-1">
                                ⚠️ Do not start your number with "+"
                            </small>
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-4">
                            <label for="email" class="form-label fw-semibold">
                                📧 Email Address
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                                   placeholder="e.g. yourname@example.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button class="btn btn-lg btn-success rounded-3 shadow-sm" type="submit">
                                💳 Renew Membership (KSh {{ config('kesa.renewal_fee', 1) }})
                            </button>
                        </div>
                    </form>

                    <p class="text-muted text-center mt-4">
                        ✅ After successful M-Pesa payment, your membership will be extended by <strong>1 year</strong>.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
