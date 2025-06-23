<!-- resources/views/thankyou.blade.php -->

@extends('layouts.app')

@section('content')

<div class="container mt-5" style="margin-left: 0px; margin-right: 0px; margin-top: 150px;">
    <!-- Hero Section with background color -->
<!-- Success or Error Message -->
@if(session('success'))
        <div class="alert alert-success text-center" style="margin-top: 150px;">
            <h4 class="alert-heading">Success!</h4>
            <p>{{ session('success') }}</p>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">
            <h4 class="alert-heading">Error!</h4>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var successMessage = "{{ session('success') }}";
        if (successMessage) {
            var myModal = new bootstrap.Modal(document.getElementById('thankYouModal'), {
                keyboard: false
            });
            myModal.show();
        }
    });
</script>
@endsection
