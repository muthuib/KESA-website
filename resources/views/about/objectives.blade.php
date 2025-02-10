@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 90px;">
        <!-- <h2>Our Objectives</h2> -->
        <div class="quill-content">
            {!! $about->OBJECTIVES ?? 'Objectives not set yet.' !!}
        </div>
    </div>
@endsection
