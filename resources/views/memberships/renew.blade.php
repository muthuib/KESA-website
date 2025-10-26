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
                    <form id="renewForm" action="{{ route('membership.renew') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

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
                            <div id="emailFeedback" class="form-text mt-2"></div>
                        </div>

                        {{-- Role info --}}
                        <div id="roleInfo" class="alert alert-info d-none mb-4"></div>

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

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button id="renewBtn" class="btn btn-lg btn-success rounded-3 shadow-sm" type="submit">
                                💳 Renew Membership
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

{{-- Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.getElementById('email');
    const feedback = document.getElementById('emailFeedback');
    const roleInfo = document.getElementById('roleInfo');
    const renewBtn = document.getElementById('renewBtn');

    // Initially disable the renew button until a valid account is found
    renewBtn.disabled = true;

    emailInput.addEventListener('blur', function () {
        const email = emailInput.value.trim();
        if (!email) {
            feedback.textContent = '';
            roleInfo.classList.add('d-none');
            renewBtn.innerHTML = '💳 Renew Membership';
            renewBtn.disabled = true;
            return;
        }

        // Show checking state
        feedback.textContent = '🔍 Checking email...';
        feedback.classList.remove('text-danger', 'text-success');
        feedback.classList.add('text-muted');
        renewBtn.disabled = true;
        roleInfo.classList.add('d-none');

        fetch("{{ route('membership.checkEmail') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.exists) {
                feedback.textContent = data.message || '❌ Account not found.';
                feedback.classList.remove('text-muted', 'text-success');
                feedback.classList.add('text-danger');
                roleInfo.classList.add('d-none');
                renewBtn.innerHTML = '💳 Renew Membership';
                renewBtn.disabled = true;
                return;
            }

            // Account exists
            feedback.textContent = data.message || '✅ Account found.';
            feedback.classList.remove('text-muted', 'text-danger');
            feedback.classList.add('text-success');

            roleInfo.innerHTML = `
                <strong>Hello you have:</strong> ${data.role.charAt(0).toUpperCase() + data.role.slice(1)} Membership <br>
                <strong>Renewal Fee:</strong> KSh ${Number(data.renewal_fee).toLocaleString()}
            `;
            roleInfo.classList.remove('d-none');

            renewBtn.innerHTML = `💳 Renew Membership (KSh ${Number(data.renewal_fee).toLocaleString()})`;
            renewBtn.disabled = false;
        })
        .catch(() => {
            feedback.textContent = '❌ Error checking email. Please try again.';
            feedback.classList.remove('text-muted', 'text-success');
            feedback.classList.add('text-danger');
            roleInfo.classList.add('d-none');
            renewBtn.innerHTML = '💳 Renew Membership';
            renewBtn.disabled = true;
        });
    });
});
</script>
@endsection
