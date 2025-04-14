@extends('layouts.app')

@section('content')
@auth
    <div class="d-flex justify-content-between align-items-left mb-3">
        <h2 class="mb-0"></h2>
        <a href="{{ route('news.index') }}" class="btn btn-dark" style="margin-top: 5px;">
            <i class="fas fa-backward"></i> Back
        </a>
    </div>
 @endauth
<!-- Full-width header with secondary background -->
<div class="text-dark py-4 px-5" 
     style="margin-top: {{ Auth::check() ? '0' : '150px' }}; margin-bottom: 8px; padding: 0px; background-color: rgb(244, 237, 237);">
    <div class="container">
        <h2 class="mb-0">{{ $news->title }}</h2>
    </div>
</div>
<div class="container mt-5">
    <div>
    @if($news->image)
    <img src="{{ asset($news->image) }}" class="mb-4 float-start me-4" style="max-width: 60%; height: auto;">

        @endif
        <p class="text-left text-muted">
            <strong>{{ \Carbon\Carbon::parse($news->date)->format('l, F j, Y') }}</strong>
        </p>
        <div class="mt-3" style="line-height: 1.7; font-size: 1.1rem; text-align: left;">
            {!! $news->content !!}
        </div>
    </div>
</div>
@endsection

