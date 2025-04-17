<!-- testimonials.blade.php -->

<div class="container-fluid mt-5 px-3" style="font-family: Arial, sans-serif;">
    <div class="row">
        <div class="col-12">
            <div class="feedback-section p-4 rounded shadow-sm bg-white w-100">
                <h1 class="feedback-title mb-4 text-center">What People Say About Us</h1>

                <!-- Testimonial Container -->
                <div id="testimonial-wrapper" class="marquee overflow-hidden">
                    <div class="marquee-group d-flex gap-4 flex-nowrap" id="marquee-group">
                        @foreach ($testimonials as $testimonial)
                            <div class="feedback-card">
                                <div id="card-{{ $testimonial->id }}" class="card shadow-sm border rounded">
                                    <div class="card-body p-3 d-flex flex-column align-items-center text-center">
                                        <img src="{{ asset('testimonials/' . $testimonial->photo) }}"
                                             alt="{{ $testimonial->name }}"
                                             class="testimonial-photo mb-2">
                                        <h2 class="feedback-name">{{ $testimonial->name }}</h2>
                                        <p class="feedback-position text-muted">{{ $testimonial->position }}</p>
                                        <p id="testimonial-{{ $testimonial->id }}" class="feedback-message">
                                            "{{ \Illuminate\Support\Str::words($testimonial->content, 8, '...') }}"
                                        </p>
                                        @if(str_word_count($testimonial->content) > 8)
                                            <button id="read-more-btn-{{ $testimonial->id }}"
                                                    class="read-more-btn btn btn-link"
                                                    data-full-text="{{ addslashes($testimonial->content) }}"
                                                    data-short-text="{{ \Illuminate\Support\Str::words($testimonial->content, 8, '...') }}">
                                                Read More
                                            </button>
                                            <button id="read-less-btn-{{ $testimonial->id }}"
                                                    class="read-less-btn btn btn-link d-none"
                                                    data-short-text="{{ \Illuminate\Support\Str::words($testimonial->content, 8, '...') }}">
                                                Read Less
                                            </button>
                                        @endif
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

<style>
    body, html {
        overflow-x: hidden;
    }

    .feedback-title {
        font-size: 2rem;
        font-weight: 600;
        color: #111827;
    }

    .feedback-name {
        font-size: 1.2rem;
        font-weight: bold;
        color: #111827;
        margin-bottom: 5px;
    }

    .feedback-position {
        font-size: 0.95rem;
        color: #6b7280;
    }

    .feedback-message {
        font-size: 0.9rem;
        color: #374151;
        max-height: 60px;
        overflow: hidden;
        transition: max-height 0.5s ease;
    }

    .feedback-message.expanded {
        white-space: normal;
        max-height: 1000px;
    }

    .feedback-card {
        width: 300px;
        flex-shrink: 0;
    }

    .card {
        width: 100%;
        border-radius: 15px;
    }

    .testimonial-photo {
        width: 100%;
        height: 160px;
        object-fit: contain;
        border-radius: 10px;
        background-color: #ffffff;
    }

    .read-more-btn,
    .read-less-btn {
        background: none;
        border: none;
        color: #2563eb;
        cursor: pointer;
        font-size: 0.8rem;
        text-decoration: underline;
    }

    .marquee {
        overflow: hidden;
        position: relative;
    }

    .marquee-group {
        display: flex;
        width: max-content;
        /* animation added dynamically */
    }

    .marquee-group.animate {
        animation: marquee 40s linear infinite;
    }

    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-100%); }
    }

    @media (max-width: 991.98px) {
        .feedback-title { font-size: 1.5rem; }
        .feedback-name { font-size: 1rem; }
        .feedback-position,
        .feedback-message,
        .read-more-btn,
        .read-less-btn { font-size: 0.8rem; }
        .testimonial-photo { height: 140px; }
        .feedback-card { width: 280px; }
    }
    .feedback-title {
        font-size: 20px;
    }

    @media (max-width: 468px) {
        .testimonial-photo { height: 120px; }
        .feedback-card { width: 90vw; }
    }
    .feedback-title {
        font-size: 20px;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const marqueeGroup = document.getElementById('marquee-group');

        // Start marquee after 4 seconds
        setTimeout(() => {
            marqueeGroup.classList.add('animate');
        }, 4000);

        // Read More button
        document.querySelectorAll('.read-more-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.id.replace('read-more-btn-', '');
                const fullText = this.getAttribute('data-full-text');
                const contentEl = document.getElementById(`testimonial-${id}`);
                const lessBtn = document.getElementById(`read-less-btn-${id}`);

                contentEl.textContent = `"${fullText}"`;
                contentEl.classList.add('expanded');
                this.classList.add('d-none');
                lessBtn.classList.remove('d-none');

                // Pause marquee
                marqueeGroup.style.animationPlayState = 'paused';
            });
        });

        // Read Less button
        document.querySelectorAll('.read-less-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.id.replace('read-less-btn-', '');
                const shortText = this.getAttribute('data-short-text');
                const contentEl = document.getElementById(`testimonial-${id}`);
                const moreBtn = document.getElementById(`read-more-btn-${id}`);

                contentEl.textContent = `"${shortText}"`;
                contentEl.classList.remove('expanded');
                this.classList.add('d-none');
                moreBtn.classList.remove('d-none');

                // Resume marquee
                marqueeGroup.style.animationPlayState = 'running';
            });
        });
    });
</script>
