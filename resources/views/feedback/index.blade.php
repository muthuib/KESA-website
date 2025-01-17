@extends('layouts.app')

@section('content')
<div style="background-color: #f3f4f6; font-family: Arial, sans-serif; padding: 20px; margin: 0;">
    <div style="width: 100%; margin: 0 auto; background: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h1 style="font-size: 28px; font-weight: bold; color: #111827; margin-bottom: 20px; text-align: center;">Users Feedback</h1>

        @foreach ($feedbacks as $feedback)
            <div style="border-bottom: 1px solid #e5e7eb; padding: 15px 0; position: relative;">
                <h2 style="font-size: 18px; font-weight: bold; color: #111827;">{{ $feedback->email }}</h2>
                <p style="font-size: 14px; color: #6b7280; margin-bottom: 10px;">Rating: 
                    <span style="color: #f59e0b; font-weight: bold;">{{ $feedback->rating }}/5</span>
                </p>
                <p id="feedback-{{ $feedback->id }}" style="font-size: 16px; color: #374151; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-height: 24px;">
                    {{ $feedback->message }}
                </p>
                @if(strlen($feedback->message) > 50)
                    <button id="read-more-btn-{{ $feedback->id }}" onclick="toggleReadMore({{ $feedback->id }})" 
                            style="background-color: transparent; border: none; color: #2563eb; cursor: pointer; font-size: 14px; margin-top: 5px;">
                        Read More
                    </button>
                @endif
                @auth
                <form action="{{ url('/feedback/' . $feedback->id) }}" method="POST" style="position: absolute; top: 10px; right: 10px;" onsubmit="return confirmDelete()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            style="background-color: #dc2626; color: #ffffff; border: none; padding: 8px 10px; border-radius: 5px; font-size: 14px; cursor: pointer;">
                        Delete
                    </button>
                </form>
    @endauth
            </div>
        @endforeach
    </div>
</div>

<script>
    function toggleReadMore(id) {
        const feedbackElement = document.getElementById(`feedback-${id}`);
        const button = document.getElementById(`read-more-btn-${id}`);

        if (feedbackElement.style.whiteSpace === 'nowrap') {
            feedbackElement.style.whiteSpace = 'normal';
            feedbackElement.style.textOverflow = 'unset';
            feedbackElement.style.maxHeight = 'none';
            button.textContent = 'Read Less';
        } else {
            feedbackElement.style.whiteSpace = 'nowrap';
            feedbackElement.style.textOverflow = 'ellipsis';
            feedbackElement.style.maxHeight = '24px';
            button.textContent = 'Read More';
        }
    }

    // JavaScript function to confirm deletion
    function confirmDelete() {
        return confirm('Do you want to delete this feedback?');
    }
</script>
@endsection
