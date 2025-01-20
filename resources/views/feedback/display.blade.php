@section('content')
<div class="container mt-5 px-3" style="background-color: #f3f4f6; font-family: Arial, sans-serif;">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="feedback-section" style="background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <h1 class="text-center" style="font-size: 28px; color: #111827; font-weight: bold; margin-bottom: 20px;">What People Say About Us</h1>

                <!-- Individual Feedbacks Section in Cards -->
                <div id="feedback-container" class="feedback-section-content" style="display: flex; flex-wrap: nowrap; padding-bottom: 20px;">
                    @foreach ($feedbacks as $feedback)
                        <div class="feedback-card" style="flex-shrink: 0; margin-right: 15px; width: 300px;">
                            <div id="card-{{ $feedback->id }}" class="card" style="border: 1px solid #e5e7eb; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                <div class="card-body" style="padding: 20px;">
                                    <h2 class="card-title" style="font-size: 18px; font-weight: bold; color: #111827;">{{ $feedback->email }}</h2>
                                    <p class="card-text" style="font-size: 14px; color: #6b7280; margin-bottom: 10px;">
                                        Rating: <span style="color: #f59e0b; font-weight: bold;">{{ $feedback->rating }}/5</span>
                                    </p>
                                    <p id="feedback-{{ $feedback->id }}" class="card-text" style="font-size: 16px; color: #374151; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-height: 50px;">
                                        "{{ $feedback->message }}"
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
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleReadMore(id) {
        const feedbackElement = document.getElementById(`feedback-${id}`);
        const cardElement = document.getElementById(`card-${id}`);
        const button = document.getElementById(`read-more-btn-${id}`);

        if (feedbackElement.style.whiteSpace === 'nowrap') {
            // Expand the feedback content and card
            feedbackElement.style.whiteSpace = 'normal';
            feedbackElement.style.textOverflow = 'unset';
            feedbackElement.style.maxHeight = 'none';
            button.textContent = 'Read Less';
            
            // Adjust the height of the card
            cardElement.style.height = 'auto';
        } else {
            // Collapse the feedback content and card
            feedbackElement.style.whiteSpace = 'nowrap';
            feedbackElement.style.textOverflow = 'ellipsis';
            feedbackElement.style.maxHeight = '50px';
            button.textContent = 'Read More';

            // Reset the height of the card
            cardElement.style.height = '150px';
        }
    }

    // JavaScript function to confirm deletion
    function confirmDelete() {
        return confirm('Do you want to delete this feedback?');
    }

    // Apply marquee effect to all feedback cards
    document.addEventListener('DOMContentLoaded', function() {
        const feedbackContainer = document.getElementById('feedback-container');
        const feedbackItems = feedbackContainer.getElementsByClassName('feedback-card');

        if (feedbackItems.length > 3) {
            feedbackContainer.classList.add('marquee');
        }
    });
</script>


<style>
    /* Apply marquee animation to the entire feedback container */
    .marquee {
        display: flex;
        animation: marquee 15s linear infinite;
    }

    @keyframes marquee {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-100%);
        }
    }

    /* Prevent overflow and keep cards in place */
    .feedback-card {
        flex-shrink: 0;
        margin-right: 15px;
    }

    /* Ensure cards do not wrap on larger screens */
    .row {
        flex-wrap: wrap !important;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 767px) {
        .feedback-card {
            width: 100% !important; /* Cards stack vertically */
        }
    }

    @media (max-width: 991px) {
        .feedback-card {
            width: 48% !important; /* Two cards per row on medium screens */
        }
    }
</style>
@endsection
