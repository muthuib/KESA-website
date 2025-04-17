@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4" style="margin-top: 100px;">Publications</h1>
    <p style="font-size: 17px; text-align:center;">
        We are committed to advancing knowledge, innovation, and sound economic thinking and practice among our members. This Hub serves as a vibrant resource center, offering a wide range of insights, right from economic trends, research findings, and industry developments.
    </p>
    <p style="font-size: 17px; margin-left: 18px;">
        Our publications aim to inform, educate and influence policies.
    </p>
    <div class="card shadow-sm">
        <div class="card-body">
            <p style="text-align: center; font-size: 25px; font-weight: bold; color: black;">Latest Publications</p>

            @forelse($publications as $publication)
            <!-- Publication Row -->
            <div class="row align-items-center mb-3 publication-row">
                <!-- Icon Column -->
                <div class="col-md-1 text-center">
                    <i class="fas fa-file-alt text-brown publication-icon"></i>
                </div>

                <!-- Details Column -->
                <div class="col-md-7">
                    <h5 class="mb-1 publication-title">{{ $publication->title }}</h5>
                    <p class="mb-1 text-muted"><strong>Author(s):</strong> {{ $publication->authors }}</p>
                    <p class="mb-1 text-muted"><strong>Description:</strong> {{ \Illuminate\Support\Str::limit(strip_tags($publication->description), 190) }}</p>
                </div>

                <!-- Uploaded Date Column -->
                <div class="col-md-2">
                    <p class="mb-0 publication-date">
                        Uploaded on {{ \Carbon\Carbon::parse($publication->created_at)->format('F j, Y') }}
                    </p>
                </div>

                <!-- Download Button Column -->
                <div class="col-md-2 text-end">
                <p class="mb-1 text-muted">
                        <strong>File Size:</strong> 
                        @php
                            // Get the file size in KB
                            $sizeInKB = $publication->file_size / 1024;

                            // If the file size is greater than or equal to 1024 KB, show in MB
                            if ($sizeInKB >= 1024) {
                                $sizeInMB = $sizeInKB / 1024;
                                echo number_format($sizeInMB, 2) . ' MB';
                            } else {
                                // Otherwise, show in KB
                                echo number_format($sizeInKB, 2) . ' KB';
                            }
                        @endphp
                    </p>
                    <p class="mb-0 text-muted"><strong>Downloads:</strong> {{ $publication->downloads ?? 0 }}</p>
                    <a href="{{ route('publications.download', $publication->id) }}" class="btn btn-primary btn-sm">
                        Download
                    </a>
                </div>
            </div>

            <!-- Animated Brown Line Divider -->
            <div class="animated-line"></div>
            @empty
                <p class="text-center text-muted">No publications available.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- CSS Styles -->
<style>
    .animated-line {
        height: 1px;
        background-color: brown;
        width: 0;
        animation: growLine 1s forwards;
        margin: 20px 0;
    }
    .publication-icon {
    font-size: 40px !important;
    color: brown !important;
    }


    @keyframes growLine {
        from { width: 0; }
        to { width: 100%; }
    }
    @media (max-width: 992px) {
        h1 { font-size: 24px !important; }
        p { font-size: 14px !important; }
        .btn-sm { font-size: 12px !important; padding: 5px 10px; }
        .publication-icon {
    font-size: 25px !important;
    color: brown !important;
    }
    }
    @media (max-width: 576px) {
        h1 { font-size: 20px !important; }
        p { font-size: 12px !important; }
        .btn-sm { font-size: 10px !important; padding: 4px 8px; }
        .publication-icon {
    font-size: 25px !important;
    color: brown !important;
    }
    }
    .publication-title { font-size: 1.2rem; font-weight: bold; }
    .publication-date { font-size: 1rem; color: #555; }
    .publication-icon { font-size: 24px; color: brown; }
    .publication-icon {
    font-size: 25px !important;
    color: brown !important;
    }
    @media (max-width: 992px) {
        .publication-title { font-size: 1rem; }
        .publication-date { font-size: 0.9rem; }
        .publication-icon { font-size: 20px; }
        .publication-icon {
    font-size: 25px !important;
    color: brown !important;
    }
    }
    @media (max-width: 768px) {
        .publication-title { font-size: 0.9rem; }
        .publication-date { font-size: 0.8rem; }
        .publication-icon { font-size: 18px; }
        .publication-icon {
    font-size: 25px !important;
    color: brown !important;
    }
    }

</style>
@endsection
