<h1>Thank you for subscribing!</h1>
<p>We are thrilled to have you as a subscriber. Stay tuned for the latest updates from us!</p>
<p>You will now receive updates from our newsletter.</p>
<div class="form-group text-center mt-4">
        <!-- Unsubscribe Button -->
        <a href="{{ route('unsubscribe', ['email' => auth()->user()->email ?? request()->email]) }}" class="btn btn-dark mt-3">
            Unsubscribe
        </a>
</div>