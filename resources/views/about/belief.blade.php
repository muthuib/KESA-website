@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 90px;">
        <!-- <h2>Our Belief</h2> -->
        <div class="quill-content">
            {!! $about->BELIEF ?? 'Belief not set yet.' !!}
        </div>
    </div>
@endsection
