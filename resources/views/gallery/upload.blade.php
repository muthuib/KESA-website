@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/gallery-upload.css') }}">
<style>
    /* ============================================
       UPLOAD OVERLAY SPINNER - FULL SCREEN
       ============================================ */
    #uploadOverlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        z-index: 999999;
        align-items: center;
        justify-content: center;
        animation: overlayFadeIn 0.4s ease;
    }
    
    #uploadOverlay.active,
    #uploadOverlay.show {
        display: flex !important;
    }
    
    @keyframes overlayFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .upload-overlay-content {
        text-align: center;
        padding: 40px;
        max-width: 450px;
        width: 90%;
        animation: contentScaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    @keyframes contentScaleIn {
        from {
            opacity: 0;
            transform: scale(0.8) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    .upload-spinner-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }
    
    .upload-spinner {
        width: 70px;
        height: 70px;
        border: 4px solid rgba(255,255,255,0.08);
        border-radius: 50%;
        border-top-color: #800000;
        border-right-color: #ff1a1a;
        animation: spinnerSpin 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) infinite;
        box-shadow: 0 0 50px rgba(128,0,0,0.15);
    }
    
    @keyframes spinnerSpin {
        to { transform: rotate(360deg); }
    }
    
    .upload-spinner-dots {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 12px;
        margin-bottom: 20px;
    }
    
    .upload-spinner-dots span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        animation: dotBounce 1.4s ease-in-out infinite;
    }
    
    .upload-spinner-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }
    .upload-spinner-dots span:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes dotBounce {
        0%, 80%, 100% { 
            transform: scale(0.6);
            opacity: 0.2;
        }
        40% { 
            transform: scale(1.2);
            opacity: 1;
        }
    }
    
    .upload-overlay-text h3 {
        color: #ffffff;
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 6px;
        letter-spacing: -0.3px;
    }
    
    .upload-overlay-text p {
        color: rgba(255,255,255,0.5);
        font-size: 15px;
        margin: 0 0 24px;
    }
    
    .upload-overlay-progress {
        width: 100%;
        height: 4px;
        background: rgba(255,255,255,0.06);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 8px;
    }
    
    .upload-overlay-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #800000, #ff1a1a, #800000);
        background-size: 200% 100%;
        border-radius: 10px;
        transition: width 0.5s ease;
        width: 0%;
        animation: progressShimmer 2s ease-in-out infinite;
    }
    
    @keyframes progressShimmer {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .upload-overlay-percentage {
        color: rgba(255,255,255,0.3);
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    @media (max-width: 480px) {
        .upload-overlay-text h3 {
            font-size: 20px;
        }
        
        .upload-overlay-text p {
            font-size: 14px;
        }
        
        .upload-spinner {
            width: 56px;
            height: 56px;
        }
    }

    .uploading-spinner {
        display: none;
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.8s ease-in-out infinite;
        margin-right: 6px;
    }
    
    .uploading-spinner.active {
        display: inline-block;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* ============================================
       UPLOAD ZONE - REDUCED & STYLED
       ============================================ */
    .upload-zone {
        border: 2px dashed #0d6efd;
        border-radius: 12px;
        background: #f8fbff;
        min-height: 180px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        padding: 25px 20px;
        position: relative;
    }

    .upload-zone:hover {
        background: #eef6ff;
        border-color: #0a58ca;
    }

    .upload-zone.dragover {
        background: #dbeeff;
        border-color: #198754;
        transform: scale(1.01);
    }

    .upload-zone .upload-icon {
        font-size: 42px;
        color: #0d6efd;
        margin-bottom: 6px;
        opacity: 0.7;
    }

    .upload-zone h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0 0 4px;
    }

    .upload-zone p {
        font-size: 13px;
        color: #6c757d;
        margin: 0 0 12px;
    }

    .upload-zone .upload-options {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .upload-zone .upload-options .btn {
        min-width: 120px;
        padding: 6px 14px;
        font-size: 13px;
        border-radius: 8px;
    }

    .upload-zone .upload-options .btn-primary {
        background: #0d6efd;
        border: none;
    }

    .upload-zone .upload-options .btn-success {
        background: #198754;
        border: none;
    }

    .upload-zone .upload-options .btn-success .browser-notice {
        font-size: 8px;
        opacity: 0.6;
        display: block;
        margin-top: 1px;
    }

    .preview-card {
        position: relative;
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
        background: #fff;
        transition: transform 0.2s;
    }

    .preview-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .preview-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .preview-card .folder-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 11px;
        z-index: 10;
    }

    .remove-btn {
        position: absolute;
        right: 10px;
        top: 10px;
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 50%;
        z-index: 10;
        opacity: 0.9;
    }

    .remove-btn:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    .progress {
        height: 20px;
    }

    .file-meta {
        font-size: 12px;
        color: #777;
    }

    .status-badge {
        font-size: 12px;
        padding: 2px 8px;
        border-radius: 12px;
    }

    .queue-controls {
        background: #f8f9fa;
        padding: 12px 16px;
        border-radius: 8px;
        margin-top: 12px;
    }

    #overallProgress {
        height: 30px;
        display: none;
    }

    #overallProgress .progress-bar {
        font-weight: bold;
        line-height: 30px;
        transition: width 0.3s ease;
    }

    .upload-stats {
        font-size: 13px;
    }

    .empty-queue {
        padding: 40px 20px;
        text-align: center;
        color: #6c757d;
    }

    .empty-queue i {
        font-size: 36px;
        margin-bottom: 10px;
        opacity: 0.5;
    }

    .folder-info {
        background: #e8f5e9;
        border-left: 4px solid #4caf50;
        padding: 8px 14px;
        border-radius: 4px;
        margin-top: 8px;
        display: none;
        font-size: 13px;
    }

    .folder-info.show {
        display: block;
    }

    /* Hide the file inputs properly */
    .hidden-input {
        position: absolute;
        width: 0;
        height: 0;
        opacity: 0;
        overflow: hidden;
        z-index: -1;
        pointer-events: none;
    }

    /* ============================================
       TOP ACTION BAR - UPLOAD & CANCEL RIGHT
       ============================================ */
    .top-action-bar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 16px;
        border: 1px solid #e9ecef;
    }

    .top-action-bar .action-left {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-right: auto;
    }

    .top-action-bar .action-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .file-count-badge {
        background: #0d6efd;
        color: white;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-upload-top {
        padding: 8px 20px;
        border-radius: 8px;
        border: none;
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
    }

    .btn-upload-top:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(40, 167, 69, 0.3);
    }

    .btn-upload-top:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-upload-top.uploading {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        animation: pulse 1.5s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    .btn-cancel-top {
        padding: 8px 20px;
        border-radius: 8px;
        border: 1px solid #dc3545;
        background: transparent;
        color: #dc3545;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-cancel-top:hover {
        background: #dc3545;
        color: white;
        box-shadow: 0 2px 12px rgba(220, 53, 69, 0.2);
    }

    @media (max-width: 768px) {
        .top-action-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .top-action-bar .action-left,
        .top-action-bar .action-right {
            justify-content: center;
        }

        .btn-upload-top,
        .btn-cancel-top {
            justify-content: center;
            flex: 1;
        }

        .upload-zone {
            min-height: 140px;
            padding: 20px 16px;
        }

        .upload-zone .upload-icon {
            font-size: 32px;
        }

        .upload-zone h3 {
            font-size: 15px;
        }

        .upload-zone p {
            font-size: 12px;
        }

        .upload-zone .upload-options .btn {
            min-width: 100px;
            font-size: 12px;
            padding: 5px 10px;
        }
    }

    @media (max-width: 480px) {
        .upload-zone {
            min-height: 120px;
            padding: 16px 12px;
        }

        .upload-zone .upload-icon {
            font-size: 28px;
        }

        .upload-zone h3 {
            font-size: 14px;
        }

        .upload-zone p {
            font-size: 11px;
            margin-bottom: 8px;
        }

        .upload-zone .upload-options {
            gap: 6px;
        }

        .upload-zone .upload-options .btn {
            min-width: 80px;
            font-size: 11px;
            padding: 4px 8px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">

    <!-- ===========================
         Event Header
    ============================ -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="mb-1">{{ $event->event_name }}</h2>
                    <p class="text-muted mb-1">{{ $event->description }}</p>
                    <small>
                        <strong>Date:</strong> {{ $event->event_date }}
                        &nbsp;&nbsp;
                        <strong>Location:</strong> {{ $event->location }}
                    </small>
                </div>
                <div>
                    <a href="{{ route('gallery.show', $event->slug) }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Gallery
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ===========================
         Flash Messages
    ============================ -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<!-- Overall Progress -->
	<div id="overallProgress" class="progress mt-4" style="height:30px; display:none;">
		<div id="overallProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width:0%">
			0%
		</div>
	</div>
    <!-- ===========================
         TOP ACTION BAR - Upload & Cancel (RIGHT ALIGNED)
    ============================ -->
    <div class="top-action-bar" id="topActionBar">
        <!-- <div class="action-left">
            <span class="file-count-badge" id="topFileCount">0 Files</span>
            <span id="topUploadStats" style="font-size:12px; color:#6c757d;">
                <i class="fa fa-check-circle text-success"></i> 0 Uploaded
                <i class="fa fa-times-circle text-danger ms-2"></i> 0 Failed
            </span>
        </div> -->

        <div class="action-right">
            <a href="{{ route('gallery.show', $event->slug) }}" class="btn-cancel-top">
                <i class="fa fa-times"></i> Cancel
            </a>
            <button type="button" id="uploadButton" class="btn-upload-top">
                <span class="uploading-spinner" id="uploadSpinner"></span>
                <i class="fa fa-upload" id="uploadIcon"></i>
                <span id="uploadButtonText">Upload Photos</span>
            </button>
        </div>
    </div>

    <!-- ===========================
         Upload Form
    ============================ -->
    <form id="uploadForm" action="{{ route('gallery.upload', $event->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card shadow-sm">
            <div class="card-header bg-prim text-white" style="background-color:maroon;">
                <i class="fa fa-cloud-upload-alt"></i> Upload Photos
                <span class="badge bg-light text-dark ms-2" id="fileCountHeader">0 Files</span>
            </div>
            <div class="card-body">
                <!-- Upload Zone - REDUCED & STYLED -->
                <div id="uploadZone" class="upload-zone">
                    <div class="upload-icon">
                        <i class="fa fa-cloud-upload-alt"></i>
                    </div>
                    <h3>Drag & Drop Photos Here</h3>
                    <p class="text-muted">or click the buttons below</p>
                    
                    <!-- Upload Options -->
                    <div class="upload-options">
                        <button type="button" id="browsePhotosBtn" class="btn btn-primary">
                            <i class="fa fa-file-image"></i> Browse Photos
                        </button>
                        <button type="button" id="browseFolderBtn" class="btn btn-success">
                            <i class="fa fa-folder"></i> Browse Folder
                            <span class="browser-notice">(Chrome, Edge, Opera)</span>
                        </button>
                    </div>
                    
                    <!-- Hidden inputs -->
                    <input id="photoInput" type="file" name="photos[]" multiple accept="image/*" class="hidden-input">
                    <input id="folderInput" type="file" name="photos[]" multiple webkitdirectory mozdirectory class="hidden-input">
                </div>

                <!-- Folder Info -->
                <div id="folderInfo" class="folder-info">
                    <i class="fa fa-folder-open"></i>
                    <span id="folderName">Folder selected</span>
                    <span class="badge bg-success ms-2" id="folderFileCount">0 files</span>
                </div>

                <!-- Queue Controls -->
                <div class="queue-controls">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-list"></i> Upload Queue
                                <span id="fileCount" class="badge bg-primary ms-2">0 Files</span>
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="button" id="clearQueueBtn" class="btn btn-outline-danger btn-sm me-2">
                                <i class="fa fa-trash"></i> Clear All
                            </button>
                            <button type="button" id="resetQueueBtn" class="btn btn-outline-warning btn-sm me-2">
                                <i class="fa fa-undo"></i> Reset
                            </button>
                            <span id="overallProgressInfo" class="upload-stats text-muted">
                                <i class="fa fa-check-circle text-success"></i> 0 Uploaded
                                <i class="fa fa-times-circle text-danger ms-2"></i> 0 Failed
                                <i class="fa fa-spinner fa-spin ms-2 text-primary"></i> 0 Processing
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Preview Container -->
                <div id="previewContainer" class="row mt-3">
                    <div class="col-12">
                        <div class="empty-queue">
                            <i class="fa fa-images"></i>
                            <p class="mb-0">No images selected. Click "Browse Photos" or "Browse Folder" to start.</p>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<!-- Pass variables to JavaScript -->
<script>
    window.uploadUrl = "{{ route('gallery.upload', $event->slug) }}";
    window.csrfToken = "{{ csrf_token() }}";
    window.eventSlug = "{{ $event->slug }}";
    
    // Debug - log the URL
    console.log('Upload URL:', window.uploadUrl);
    console.log('Event Slug:', window.eventSlug);
</script>

<!-- Include the JavaScript with defer -->
<script src="{{ asset('js/gallery-upload.js') }}" defer></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Gallery upload page loaded');
        console.log('Upload URL:', window.uploadUrl);
        console.log('Event Slug:', window.eventSlug);
    });
</script>
@endsection