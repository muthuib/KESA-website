@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>About Us</h2>
         <!-- Add Team Members Button -->
         <a href="{{ route('team-members.index') }}" class="btn btn-primary">
            <i class="fas fa-users"></i> Add Team Members
        </a>
        <!-- Add Team Members Button -->
        <a href="{{ route('about-slides.index') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> About us slides
        </a>
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

    <!-- About  Section -->
    <div class="about-section">
        <h3>About KESA</h3>
        <div class="quill-content">
            {!! $about->ABOUT ?? '<p>About KESA not set yet.</p>' !!}
        </div>
    </div>
    <div class="animated-line"></div>

    <!-- Vision Section -->
    <div class="about-section">
        <h3>Our Vision</h3>
        <div class="quill-content">
            {!! $about->VISION ?? '<p>Vision not set yet.</p>' !!}
        </div>
    </div>
    <div class="animated-line"></div>

    <!-- Mission Section -->
    <div class="about-section">
        <h3>Our Mission</h3>
        <div class="quill-content">
            {!! $about->MISSION ?? '<p>Mission not set yet.</p>' !!}
        </div>
    </div>
    <div class="animated-line"></div>

    <!-- Objectives Section -->
    <div class="about-section">
        <h3>Our Objectives</h3>
        <div class="quill-content">
            {!! $about->OBJECTIVES ?? '<p>Objectives not set yet.</p>' !!}
        </div>
    </div>
    <div class="animated-line"></div>

    <!-- Motto Section -->
    <div class="about-section">
        <h3>Our Motto</h3>
        <div class="quill-content">
            {!! $about->MOTTO ?? '<p>Motto not set yet.</p>' !!}
        </div>
    </div>
    <div class="animated-line"></div>

    <!-- Belief Section -->
    <div class="about-section">
        <h3>Our Values</h3>
        <div class="quill-content">
            {!! $about->BELIEF ?? '<p>Belief not set yet.</p>' !!}
        </div>
    </div>
</div>
@endsection

<!-- Inline CSS for modern design and animated dividers -->
<style>
    .about-section {
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .quill-content {
        font-size: 1.125rem;
        line-height: 1.6;
        color: #333;
    }
    .animated-line {
        height: 4px;
        background-color: brown;
        width: 0;
        margin: 30px 0;
        animation: growLine 2s forwards;
    }
    @keyframes growLine {
        from { width: 0; }
        to { width: 100%; }
    }
</style>
