@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2>About Us</h2>
            <!-- Add About Us Button -->
            <a href="{{ route('about.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Add About Us
            </a>

            <!-- Edit About Us Button (if record exists) -->
            @if(isset($about) && !empty($about->ID))
                <a href="{{ route('about.edit', $about->ID) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit About Us
                </a>
                
                <!-- Delete About Us Button (if record exists) -->
                <form action="{{ route('about.destroy', $about->ID) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">
                        <i class="fas fa-trash-alt"></i> Delete About Us
                    </button>
                </form>
            @endif
        </div>

        <!-- <h3>Vision</h3> -->
        {!! $about->VISION ?? '<p>Vision not set yet.</p>' !!}

        <!-- <h3>Mission</h3> -->
        {!! $about->MISSION ?? '<p>Mission not set yet.</p>' !!}

        <!-- <h3>Objectives</h3> -->
        {!! $about->OBJECTIVES ?? '<p>Objectives not set yet.</p>' !!}
    </div>
@endsection
