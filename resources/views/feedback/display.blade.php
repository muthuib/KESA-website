@section('content')
<div class="container mt-5 px-3" style="background-color: #ffffff; font-family: Arial, sans-serif; overflow-x: hidden;">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="feedback-section p-4 rounded shadow-sm" style="background-color: #ffffff;">
                <h1 class="text-center feedback-title">What People Say About Us</h1>

                <!-- Feedback Container with Marquee -->
                <div id="feedback-wrapper" class="overflow-hidden">
                    <div id="feedback-container" class="d-flex flex-nowrap pb-3">
                        @foreach ($feedbacks->take(10) as $feedback)
                            <div class="feedback-card mx-2">
                                <div id="card-{{ $feedback->id }}" class="card shadow-sm border">
                                    <div class="card-body p-3">
                                        <h2 class="feedback-email">{{ $feedback->email }}</h2>
                                        <p class="feedback-rating">Rating: <span class="text-warning font-weight-bold">{{ $feedback->rating }}/5</span></p>
                                        <p id="feedback-{{ $feedback->id }}" class="feedback-message">
                                                "{{ \Illuminate\Support\Str::words($feedback->message, 8, '...') }}"
                                            </p>

                                            @if(str_word_count($feedback->message) > 8)
                                                <button id="read-more-btn-{{ $feedback->id }}" onclick="toggleReadMore({{ $feedback->id }}, '{{ addslashes($feedback->message) }}')" class="read-more-btn">
                                                    Read More
                                                </button>
                                            @endif

                                        

                                        @auth
                                            <form action="{{ url('/feedback/' . $feedback->id) }}" method="POST" class="delete-form" onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-btn">Delete</button>
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
</div>

<script>
  function toggleReadMore(id, fullText) {
    const feedbackElement = document.getElementById(`feedback-${id}`);
    const button = document.getElementById(`read-more-btn-${id}`);

    if (button.textContent === 'Read More') {
        feedbackElement.textContent = `"${fullText}"`;
        button.textContent = 'Read Less';
    } else {
        const truncatedText = fullText.split(" ").slice(0, 8).join(" ") + "...";
        feedbackElement.textContent = `"${truncatedText}"`;
        button.textContent = 'Read More';
    }
}

    function confirmDelete() {
        return confirm('Do you want to delete this feedback?');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const feedbackContainer = document.getElementById('feedback-container');
        if (feedbackContainer.children.length > 3) {
            feedbackContainer.classList.add('marquee');
        }
    });
</script>

<style>
    /* Prevent horizontal scrolling */
    body, html {
        overflow-x: hidden;
    }

    /* Feedback Section Styles */
    .feedback-title {
        font-size: 28px;
        font-weight: bold;
        color: #111827;
    }

    .feedback-email {
        font-size: 18px;
        font-weight: bold;
        color: #111827;
    }

    .feedback-rating {
        font-size: 14px;
        color: #6b7280;
    }

    .feedback-message {
        font-size: 16px;
        color: #374151;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        max-height: 50px;
    }

    .read-more-btn {
        background: none;
        border: none;
        color: #2563eb;
        cursor: pointer;
        font-size: 14px;
    }

    .delete-form {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .delete-btn {
        background-color: #dc2626;
        color: #ffffff;
        border: none;
        padding: 8px 10px;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
    }

    /* Marquee Animation */
    .marquee {
        display: flex;
        gap: 15px;
        animation: marquee 40s linear infinite;
        will-change: transform;
    }

    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }

    /* Ensure no horizontal scroll on small screens */
    @media (max-width: 767px) {
        .feedback-title {
            font-size: 16px !important;
        }

        .feedback-email {
            font-size: 14px !important;
        }

        .feedback-rating {
            font-size: 12px !important;
        }

        .feedback-message {
            font-size: 10px !important;
        }

        .read-more-btn {
            font-size: 10px !important;
        }

        .marquee {
            animation: marquee 60s linear infinite;
        }

        #feedback-wrapper {
            overflow-x: hidden;
        }

        #feedback-container {
            display: flex;
            flex-wrap: nowrap;
            width: max-content;
        }
    }

    @media (max-width: 991px) {
        .feedback-title {
            font-size: 24px !important;
        }

        .feedback-email {
            font-size: 16px !important;
        }

        .feedback-rating {
            font-size: 14px !important;
        }

        .feedback-message {
            font-size: 12px !important;
        }
    }
</style>
@endsection
