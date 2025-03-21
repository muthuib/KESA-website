@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 90px;">
        <!-- <h2>Our Motto</h2> -->
        <div class="quill-content">
            {!! $about->MOTTO ?? 'Motto not set yet.' !!}
        </div>
    </div>
@endsection
