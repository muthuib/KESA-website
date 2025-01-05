@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 110px;">
    <!-- Alert Message -->
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 30px;"><i class="fas fa-check-circle me-2 fs-3 text-success" style="font-size: 1.5rem;"></i>
        <strong>Payment Initiated Successfully!</strong> A pop-up has been sent to your phone. Check your phone and input your M-Pesa PIN to complete the purchase. Thank you.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

 <div class="text-center mt-3">
    @if (auth()->check())
        <a href="{{ route('user-dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
    @else
        <a href="/" class="btn btn-primary">Back to Home</a>
    @endif
</div>

</div>
@endsection
