@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>{{ $publication->title }}</h1>
         <!-- Back Button at Top Right -->
         <a href="{{ route('publications.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
             <i class="fas fa-backward"></i> Back
          </a>
    <p>
        <a href="{{ route('publications.download', $publication->id) }}" class="btn btn-success">
            Download Publication
        </a>
    </p>
</div>
@endsection
