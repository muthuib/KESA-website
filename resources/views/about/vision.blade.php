@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 90px;">
        <!-- <h2>Our Vision</h2> -->
        <div class="quill-content">
            {!! $about->VISION ?? 'Vision not set yet.' !!}
        </div>
    </div>
@endsection
