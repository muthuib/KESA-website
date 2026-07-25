@extends('layouts.app')

@section('styles')
<style>
    /* ============================================
       EDIT GALLERY EVENT - WORLD CLASS STYLING
       ============================================ */
    .edit-gallery-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .edit-gallery-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 
            0 20px 60px rgba(0,0,0,0.06),
            0 8px 24px rgba(0,0,0,0.04);
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.3);
        transition: all 0.3s ease;
    }

    .edit-gallery-card:hover {
        box-shadow: 
            0 30px 80px rgba(0,0,0,0.08),
            0 12px 32px rgba(0,0,0,0.05);
    }

    /* Header */
    .edit-gallery-header {
        padding: 8px 32px 4px;
        background: linear-gradient(145deg, #0d0505, #1a0a0a);
        border-bottom: 1px solid rgba(128,0,0,0.15);
        position: relative;
        overflow: hidden;
    }

    .edit-gallery-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 30% 50%, rgba(128,0,0,0.05), transparent 70%);
        pointer-events: none;
    }

    .edit-gallery-header .header-content {
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
        z-index: 1;
    }

    .edit-gallery-header .header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(145deg, #800000, #4a0000);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        box-shadow: 0 4px 16px rgba(128,0,0,0.2);
        flex-shrink: 0;
    }

    .edit-gallery-header h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: -0.3px;
    }

    .edit-gallery-header .header-subtitle {
        font-size: 13px;
        color: rgba(255,255,255,0.4);
        margin: 2px 0 0;
    }

    /* Body */
    .edit-gallery-body {
        padding: 32px;
    }

    /* Form Labels */
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 6px;
        display: block;
        letter-spacing: 0.2px;
    }

    .form-label .required-star {
        color: #dc3545;
        margin-left: 2px;
    }

    .form-label .label-icon {
        margin-right: 6px;
        color: #800000;
        opacity: 0.7;
    }

    /* Form Controls */
    .form-control {
        padding: 12px 16px;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f8f9fa;
        color: #1a1a2e;
        width: 100%;
    }

    .form-control:focus {
        border-color: #800000;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(128,0,0,0.06);
        outline: none;
    }

    .form-control::placeholder {
        color: #adb5bd;
        font-size: 14px;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 22px;
    }

    .form-group:last-of-type {
        margin-bottom: 28px;
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge.published {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.draft {
        background: #fff3cd;
        color: #856404;
    }

    /* Form Select */
    .form-select {
        padding: 12px 16px;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f8f9fa;
        color: #1a1a2e;
        width: 100%;
        cursor: pointer;
    }

    .form-select:focus {
        border-color: #800000;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(128,0,0,0.06);
        outline: none;
    }

    /* Row Layout */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    /* Submit Button */
    .btn-submit {
        padding: 14px 36px;
        border-radius: 12px;
        border: none;
        background: blue;
        color: white;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 20px rgba(128,0,0,0.25);
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.5s ease;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 32px rgba(128,0,0,0.35);
        color: white;
    }

    .btn-submit:hover::before {
        transform: translateX(100%);
    }

    .btn-submit:active {
        transform: translateY(0);
        box-shadow: 0 4px 16px rgba(128,0,0,0.20);
    }

    .btn-submit i {
        font-size: 18px;
    }

    /* Alert Messages */
    .alert {
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 16px;
        border: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideDown 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .alert i {
        font-size: 18px;
        flex-shrink: 0;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert ul li {
        margin-bottom: 2px;
    }

    /* Cancel Button */
    .btn-cancel {
        padding: 14px 28px;
        border-radius: 12px;
        border: 2px solid #e9ecef;
        background: grey;
        color: white;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel:hover {
        background: #f8f9fa;
        border-color: #dee2e6;
        color: #495057;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-top: 8px;
    }

    /* Info Box */
    .info-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 22px;
        border-left: 4px solid #800000;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-box i {
        color: #800000;
        font-size: 18px;
    }

    .info-box .info-text {
        font-size: 13px;
        color: #6c757d;
        margin: 0;
    }

    .info-box .info-text strong {
        color: #1a1a2e;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .edit-gallery-container {
            padding: 0 12px;
            margin: 20px auto;
        }

        .edit-gallery-header {
            padding: 20px 20px 16px;
        }

        .edit-gallery-body {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .edit-gallery-header h3 {
            font-size: 20px;
        }

        .form-actions {
            flex-direction: column;
            gap: 10px;
        }

        .btn-submit,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .edit-gallery-header .header-content {
            gap: 10px;
        }

        .edit-gallery-header .header-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
            border-radius: 10px;
        }

        .edit-gallery-header h3 {
            font-size: 17px;
        }

        .edit-gallery-body {
            padding: 16px;
        }

        .form-control {
            padding: 10px 14px;
            font-size: 14px;
        }

        .btn-submit {
            padding: 12px 24px;
            font-size: 14px;
        }

        .btn-cancel {
            padding: 12px 20px;
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="edit-gallery-card">

        <!-- Header -->
        <div class="edit-gallery-header">
            <div class="header-content">
                <div class="header-icon">
                    <i class="fa fa-pencil"></i>
                </div>
                <div>
                    <h3>Edit Gallery Event</h3>
                    <p class="header-subtitle" style="color:white;">Update your event details</p>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="edit-gallery-body">

            <!-- Alert Messages -->
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-triangle"></i>
                    <div>
                        <strong>Please fix the following errors:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Info Box -->
            <!-- <div class="info-box">
                <i class="fa fa-info-circle"></i>
                <p class="info-text">
                    <strong>Current Slug:</strong> {{ $event->slug }}
                    <span style="margin-left: 12px;">
                        <strong>Status:</strong>
                        <span class="status-badge {{ strtolower($event->status) == 'published' ? 'published' : 'draft' }}">
                            {{ $event->status ?? 'Published' }}
                        </span>
                    </span>
                </p>
            </div> -->

            <!-- Form -->
            <form action="{{ route('gallery.update', $event->slug) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Event Name -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fa fa-tag label-icon"></i>
                        Event Name
                        <span class="required-star">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        name="event_name"
                        placeholder="e.g., KESA National Debate"
                        required
                        value="{{ old('event_name', $event->event_name) }}">
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fa fa-align-left label-icon"></i>
                        Description
                    </label>
                    <textarea
                        class="form-control"
                        rows="4"
                        name="description"
                        placeholder="Describe the event...">{{ old('description', $event->description) }}</textarea>
                </div>

                <!-- Event Date & Location -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fa fa-calendar label-icon"></i>
                            Event Date
                            <span class="required-star">*</span>
                        </label>
                        <input
                            type="date"
                            class="form-control"
                            name="event_date"
                            required
                            value="{{ old('event_date', $event->event_date) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fa fa-map-marker label-icon"></i>
                            Location
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="location"
                            placeholder="e.g., Nairobi, Kenya"
                            value="{{ old('location', $event->location) }}">
                    </div>
                </div>

                <!-- Status -->
                <!-- <div class="form-group">
                    <label class="form-label">
                        <i class="fa fa-toggle-on label-icon"></i>
                        Status
                    </label>
                    <select class="form-select" name="status">
                        <option value="Published" {{ old('status', $event->status) == 'Published' ? 'selected' : '' }}>
                            <i class="fa fa-check-circle"></i> Published
                        </option>
                        <option value="Draft" {{ old('status', $event->status) == 'Draft' ? 'selected' : '' }}>
                            <i class="fa fa-pencil-square-o"></i> Draft
                        </option>
                    </select>
                </div> -->

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fa fa-save"></i>
                        Update Event
                    </button>
                    <a href="{{ route('gallery.show', $event->slug) }}" class="btn-cancel">
                        <i class="fa fa-times"></i>
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection