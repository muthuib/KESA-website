@extends('layouts.app')

@section('content')
    <div class="container about-container" style="margin-top: 90px;">
        <div class="quill-content">
            {!! $about->ABOUT ?? 'About not set yet.' !!}
        </div>
    </div>

    <style>
        /* Ensure text wraps and is readable */
        .quill-content {
            font-size: 20px;
            line-height: 1.6;
            color: #333;
        }

        /* Make it responsive for small devices */
        @media (max-width: 767px) {
            .quill-content {
                font-size: 8px;
                line-height: 1.5;
            }
        }

        @media (max-width: 991px) {
            .quill-content {
                font-size: 10px;
            }
        }
    </style>
@endsection
