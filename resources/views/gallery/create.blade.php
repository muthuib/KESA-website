@extends('layouts.app')

@section('styles')
<style>
    .create-gallery-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .create-gallery-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 
            0 20px 60px rgba(0,0,0,0.06),
            0 8px 24px rgba(0,0,0,0.04);
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.3);
        transition: all 0.3s ease;
    }

    .create-gallery-card:hover {
        box-shadow: 
            0 30px 80px rgba(0,0,0,0.08),
            0 12px 32px rgba(0,0,0,0.05);
    }

    .create-gallery-header {
        padding: 8px 32px 4px;
        background: linear-gradient(145deg, #0d0505, #1a0a0a);
        border-bottom: 1px solid rgba(128,0,0,0.15);
        position: relative;
        overflow: hidden;
    }

    .create-gallery-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 30% 50%, rgba(128,0,0,0.05), transparent 70%);
        pointer-events: none;
    }

    .create-gallery-header .header-content {
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
        z-index: 1;
    }

    .create-gallery-header .header-icon {
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

    .create-gallery-header h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: -0.3px;
    }

    .create-gallery-header .header-subtitle {
        font-size: 13px;
        color: rgba(255,255,255,0.4);
        margin: 2px 0 0;
    }

    .create-gallery-body {
        padding: 32px;
    }

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

    .form-group {
        margin-bottom: 22px;
    }

    .form-group:last-of-type {
        margin-bottom: 28px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-row-three {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-row-four {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    input[type="time"] {
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

    input[type="time"]:focus {
        border-color: #800000;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(128,0,0,0.06);
        outline: none;
    }

    input[type="time"]::-webkit-calendar-picker-indicator {
        opacity: 0.6;
        padding: 4px;
        cursor: pointer;
    }

    input[type="time"]::-webkit-calendar-picker-indicator:hover {
        opacity: 1;
    }

    .btn-submit {
        padding: 14px 36px;
        border-radius: 12px;
        border: none;
        background: green;
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

    @media (max-width: 992px) {
        .form-row-four {
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
    }

    @media (max-width: 768px) {
        .create-gallery-container {
            padding: 0 12px;
            margin: 20px auto;
        }

        .create-gallery-header {
            padding: 20px 20px 16px;
        }

        .create-gallery-body {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .form-row-three {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .form-row-four {
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .create-gallery-header h3 {
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
        .create-gallery-header .header-content {
            gap: 10px;
        }

        .create-gallery-header .header-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
            border-radius: 10px;
        }

        .create-gallery-header h3 {
            font-size: 17px;
        }

        .create-gallery-body {
            padding: 16px;
        }

        .form-control {
            padding: 10px 14px;
            font-size: 14px;
        }

        input[type="time"] {
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

        .form-row-four {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="create-gallery-card">
        <div class="create-gallery-header">
            <div class="header-content">
                <div class="header-icon">
                    <i class="fa fa-plus-circle"></i>
                </div>
                <div>
                    <h3>Create Gallery Event</h3>
                    <p class="header-subtitle" style="color:white;">Add a new event to showcase your photos</p>
                </div>
            </div>
        </div>

        <div class="create-gallery-body">
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

            <form action="{{ route('gallery.store') }}" method="POST">
                @csrf

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
                        placeholder="e.g., KESA Annual Debate"
                        required
                        value="{{ old('event_name') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fa fa-align-left label-icon"></i>
                        Description
                    </label>
                    <textarea
                        class="form-control"
                        rows="4"
                        name="description"
                        placeholder="Describe the event...">{{ old('description') }}</textarea>
                </div>

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
                            value="{{ old('event_date') }}">
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
                            value="{{ old('location') }}">
                    </div>
                </div>

                <div class="form-row-three">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fa fa-calendar-check-o label-icon"></i>
                            Event End Date
                        </label>
                        <input
                            type="date"
                            class="form-control"
                            name="event_end_date"
                            value="{{ old('event_end_date') }}">
                        <small class="text-muted" style="font-size: 12px; color: #6c757d; display: block; margin-top: 4px;">
                            Leave blank if single-day event
                        </small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fa fa-eye label-icon"></i>
                            Display End Date
                        </label>
                        <input
                            type="date"
                            class="form-control"
                            name="display_end_date"
                            value="{{ old('display_end_date') }}">
                        <small class="text-muted" style="font-size: 12px; color: #6c757d; display: block; margin-top: 4px;">
                            When to stop displaying this event
                        </small>
                    </div>
                </div>

                <div class="form-row-four">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fa fa-clock-o label-icon"></i>
                            Start Time
                        </label>
                        <input
                            type="time"
                            class="form-control"
                            name="start_time"
                            value="{{ old('start_time') }}">
                        <small class="text-muted" style="font-size: 12px; color: #6c757d; display: block; margin-top: 4px;">
                            e.g., 09:00 AM
                        </small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fa fa-clock-o label-icon"></i>
                            End Time
                        </label>
                        <input
                            type="time"
                            class="form-control"
                            name="end_time"
                            value="{{ old('end_time') }}">
                        <small class="text-muted" style="font-size: 12px; color: #6c757d; display: block; margin-top: 4px;">
                            e.g., 05:00 PM
                        </small>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fa fa-plus-circle"></i>
                        Create Event
                    </button>
                    <a href="{{ route('gallery.index') }}" class="btn-cancel">
                        <i class="fa fa-times"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection