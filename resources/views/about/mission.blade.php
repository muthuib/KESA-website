@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 90px;">
        <!-- <h2>Our Mission</h2> -->
        <div class="quill-content">
            {!! $about->MISSION ?? 'Mission not set yet.' !!}
        </div>
    </div>
@endsection
