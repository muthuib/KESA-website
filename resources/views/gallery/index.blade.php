@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/gallery-index.css') }}">
<style>
    /* ============================================
       PAGE HEADER 
       ============================================ */
    .gallery-page-header {
        position: relative;
        padding: 5px 3px 4px;
		margin-top: 20px;
        margin-bottom: 35px;
        /* background: linear-gradient(145deg, #0d0505 0%, #1a0a0a 30%, #2d1515 60%, #1a0a0a 100%); */
        border-radius: 20px;
        overflow: hidden;
        text-align: center;
        border: 1px solid rgba(128, 0, 0, 0.15);
        box-shadow: 
            0 20px 60px rgba(0,0,0,0.5),
            inset 0 1px 0 rgba(128,0,0,0.1);
    }

    /* Animated Orbs */
    .header-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(100px);
        pointer-events: none;
        animation: orbFloat 18s ease-in-out infinite;
    }

    .header-orb-1 {
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(128,0,0,0.20), transparent 70%);
        top: -120px;
        right: -80px;
        animation-delay: 0s;
    }

    .header-orb-2 {
        width: 280px;
        height: 280px;
        background: radial-gradient(circle, rgba(128,0,0,0.15), transparent 70%);
        bottom: -100px;
        left: -60px;
        animation-delay: -6s;
    }

    .header-orb-3 {
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(180,0,0,0.10), transparent 70%);
        top: 50%;
        left: 50%;
        transform: translateX(-50%);
        animation-delay: -12s;
    }

    .header-orb-4 {
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(200,50,50,0.06), transparent 70%);
        bottom: 20%;
        right: 20%;
        animation-delay: -4s;
    }

    @keyframes orbFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(40px, -30px) scale(1.1); }
        50% { transform: translate(-30px, 40px) scale(0.9); }
        75% { transform: translate(30px, 20px) scale(1.05); }
    }

    /* Gradient Overlay */
    .header-gradient-overlay {
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 50% 30%, rgba(128,0,0,0.05), transparent 70%);
        pointer-events: none;
    }

    /* ===== CONTENT ===== */
    .header-content {
        position: relative;
        z-index: 1;
    }

    /* ===== TITLE WRAPPER ===== */
    .header-title-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    /* ===== ICON WITH PREMIUM EFFECTS ===== */
    .header-icon-wrapper {
        position: relative;
        display: inline-block;
        flex-shrink: 0;
    }

    .header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 72px;
        height: 72px;
        background: linear-gradient(145deg, #800000, #3d0000);
        border-radius: 20px;
        color: white;
        font-size: 32px;
        position: relative;
        z-index: 2;
        animation: iconFloat 4s ease-in-out infinite;
        cursor: default;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 8px 40px rgba(128,0,0,0.30);
        border: 1px solid rgba(128,0,0,0.2);
    }

    .header-icon:hover {
        transform: scale(1.08) rotate(-5deg);
        box-shadow: 0 16px 56px rgba(128,0,0,0.45);
    }

    /* Icon Glow */
    .icon-glow {
        position: absolute;
        inset: -10px;
        border-radius: 28px;
        background: radial-gradient(circle at center, rgba(128,0,0,0.25), transparent 70%);
        animation: glowPulse 3s ease-in-out infinite;
    }

    @keyframes glowPulse {
        0%, 100% { opacity: 0.4; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.08); }
    }

    /* Icon Rings */
    .icon-ring {
        position: absolute;
        border-radius: 28px;
        border: 2px solid rgba(128,0,0,0.08);
        animation: ringPulse 4s ease-in-out infinite;
        z-index: 1;
    }

    .icon-ring:first-of-type {
        inset: -8px;
        border-color: rgba(128,0,0,0.12);
    }

    .ring-2 {
        inset: -18px;
        border-color: rgba(128,0,0,0.06);
        animation-delay: 1.5s;
    }

    .ring-3 {
        inset: -28px;
        border-color: rgba(128,0,0,0.03);
        animation-delay: 3s;
    }

    @keyframes ringPulse {
        0%, 100% { transform: scale(1); opacity: 0.2; }
        50% { transform: scale(1.2); opacity: 0; }
    }

    /* Sparkles */
    .icon-sparkle {
        position: absolute;
        color: rgba(255,255,255,0.12);
        font-size: 10px;
        animation: sparkleFloat 6s ease-in-out infinite;
        pointer-events: none;
        z-index: 3;
    }

    .sparkle-1 {
        top: -10px;
        right: -10px;
        animation-delay: 0s;
    }

    .sparkle-2 {
        bottom: -10px;
        left: -10px;
        animation-delay: 3s;
    }

    .sparkle-3 {
        top: 50%;
        right: -15px;
        animation-delay: 1.5s;
    }

    @keyframes sparkleFloat {
        0%, 100% { opacity: 0; transform: scale(0.5) rotate(0deg); }
        25% { opacity: 1; transform: scale(1.2) rotate(90deg); }
        75% { opacity: 0.5; transform: scale(0.8) rotate(180deg); }
    }

    @keyframes iconFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    /* ===== TITLE WITH VISIBLE SHIMMER ===== */
    .header-title {
        margin: 0;
        position: relative;
        display: inline-block;
        text-align: left;
    }

    .title-text {
        font-size: 44px;
        font-weight: 900;
        letter-spacing: -0.5px;
        color: #ffffff;
        text-shadow: 
            0 2px 30px rgba(128,0,0,0.15),
            0 4px 60px rgba(0,0,0,0.3);
        position: relative;
        display: inline-block;
        z-index: 1;
    }

    /* Title Shimmer - VISIBLE & PREMIUM */
    .title-shimmer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(255,255,255,0.05) 15%,
            rgba(255,255,255,0.2) 25%,
            rgba(255,255,255,0.4) 35%,
            rgba(255,255,255,0.6) 45%,
            rgba(255,255,255,0.4) 55%,
            rgba(255,255,255,0.2) 65%,
            rgba(255,255,255,0.05) 75%,
            transparent 100%
        );
        background-size: 300% 100%;
        animation: titleShimmer 3.5s ease-in-out infinite;
        pointer-events: none;
        z-index: 2;
        border-radius: 4px;
        mix-blend-mode: overlay;
    }

    @keyframes titleShimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* Title Underline */
    .title-underline {
        display: block;
        width: 70px;
        height: 4px;
        margin: 10px auto 0 0;
        background: linear-gradient(90deg, #800000, #ff1a1a, #800000);
        border-radius: 4px;
        position: relative;
        animation: underlineGrow 1.2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        box-shadow: 0 0 30px rgba(128,0,0,0.3);
    }

    .title-underline::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: underlineShimmer 2s ease-in-out infinite;
        border-radius: 4px;
    }

    @keyframes underlineGrow {
        from { width: 0; opacity: 0; }
        to { width: 70px; opacity: 1; }
    }

    @keyframes underlineShimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* ===== SUBTITLE ===== */
    .header-subtitle {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        margin: 18px auto 0;
        max-width: 500px;
        font-size: 15px;
        color: rgba(255,255,255,0.35);
    }

    .subtitle-line {
        flex: 1;
        max-width: 60px;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(128,0,0,0.3));
    }

    .subtitle-line:last-child {
        background: linear-gradient(90deg, rgba(128,0,0,0.3), transparent);
    }

    .subtitle-text {
        font-weight: 300;
        letter-spacing: 0.5px;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 10px;
    }

    .subtitle-icon {
        font-size: 12px;
        color: rgba(128,0,0,0.3);
        animation: iconRotate 8s linear infinite;
    }

    @keyframes iconRotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* ============================================
       GALLERY GRID
       ============================================ */
    .gallery-grid-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    .gallery-event-card {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        opacity: 0;
        transform: translateY(20px);
        animation: cardFadeIn 0.5s ease forwards;
    }

    .gallery-event-card:nth-child(1) { animation-delay: 0.05s; }
    .gallery-event-card:nth-child(2) { animation-delay: 0.10s; }
    .gallery-event-card:nth-child(3) { animation-delay: 0.15s; }
    .gallery-event-card:nth-child(4) { animation-delay: 0.20s; }
    .gallery-event-card:nth-child(5) { animation-delay: 0.25s; }
    .gallery-event-card:nth-child(6) { animation-delay: 0.30s; }
    .gallery-event-card:nth-child(7) { animation-delay: 0.35s; }
    .gallery-event-card:nth-child(8) { animation-delay: 0.40s; }
    .gallery-event-card:nth-child(9) { animation-delay: 0.45s; }

    @keyframes cardFadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .gallery-event-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.10);
    }

    .gallery-event-card .card-img-wrapper {
        position: relative;
        overflow: hidden;
        height: 180px;
        background: #f8f9fa;
    }

    .gallery-event-card .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.5s ease;
    }

    .gallery-event-card:hover .card-img-wrapper img {
        transform: scale(1.06);
    }

    .gallery-event-card .card-img-wrapper .image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, transparent 40%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        justify-content: flex-start;
        padding: 16px;
    }

    .gallery-event-card:hover .card-img-wrapper .image-overlay {
        opacity: 1;
    }

    .gallery-event-card .card-img-wrapper .image-overlay .quick-view {
        padding: 4px 12px;
        background: rgba(128,0,0,0.7);
        backdrop-filter: blur(4px);
        border-radius: 6px;
        color: white;
        font-size: 11px;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.05);
        transition: all 0.3s ease;
    }

    .gallery-event-card .card-img-wrapper .image-overlay .quick-view:hover {
        background: rgba(128,0,0,0.9);
        transform: scale(1.05);
    }

    .gallery-event-card .card-img-wrapper .image-count {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(4px);
        color: white;
        padding: 2px 10px;
        border-radius: 16px;
        font-size: 11px;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.05);
    }

    .gallery-event-card .card-img-wrapper .image-count i {
        margin-right: 3px;
        font-size: 10px;
    }

    .gallery-event-card .card-body {
        padding: 14px 16px 16px;
    }

    .gallery-event-card .card-title {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 4px;
        color: #1a1a2e;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 40px;
        transition: color 0.3s ease;
    }

    .gallery-event-card:hover .card-title {
        color: #800000;
    }

    .gallery-event-card .card-text {
        font-size: 12px;
        color: #6c757d;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 36px;
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .event-date-location {
        font-size: 11px;
        color: #6c757d;
        margin-bottom: 10px;
        padding: 6px 10px;
        background: #f8f9fa;
        border-radius: 6px;
        transition: background 0.3s ease;
    }

    .gallery-event-card:hover .event-date-location {
        background: #f0f0f0;
    }

    .event-date-location div {
        margin-bottom: 1px;
    }

    .event-date-location i {
        width: 14px;
        margin-right: 4px;
        color: #800000;
        font-size: 11px;
    }

    /* View Album Button - Maroon */
    .btn-view-album {
        padding: 8px 16px;
        border-radius: 8px;
        background: linear-gradient(135deg, #800000, #4a0000);
        border: none;
        color: white;
        font-weight: 600;
        font-size: 13px;
        width: 100%;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow: hidden;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        position: relative;
    }

    .btn-view-album::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.5s ease;
    }

    .btn-view-album:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(128,0,0,0.30);
        color: white;
        text-decoration: none;
    }

    .btn-view-album:hover::before {
        transform: translateX(100%);
    }

    .btn-view-album i {
        margin-right: 4px;
        font-size: 12px;
    }

    /* Edit Button - Admin Only */
    .btn-edit-event {
        position: absolute;
        top: 10px;
        right: 48px;
        z-index: 10;
        background: rgba(40, 167, 69, 0.9);
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        opacity: 0;
        backdrop-filter: blur(4px);
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }

    .gallery-event-card:hover .btn-edit-event {
        opacity: 1;
    }

    .btn-edit-event:hover {
        background: #28a745;
        transform: scale(1.1);
        box-shadow: 0 4px 16px rgba(40, 167, 69, 0.5);
    }

    .btn-edit-event i {
        font-size: 14px;
    }

    /* Delete Button - Admin Only */
    .btn-delete-event {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        background: rgba(220, 53, 69, 0.9);
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        opacity: 0;
        backdrop-filter: blur(4px);
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }

    .gallery-event-card:hover .btn-delete-event {
        opacity: 1;
    }

    .btn-delete-event:hover {
        background: #dc3545;
        transform: scale(1.1);
        box-shadow: 0 4px 16px rgba(220, 53, 69, 0.5);
    }

    .btn-delete-event i {
        font-size: 14px;
    }

    /* Delete Confirmation Modal */
    .delete-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(8px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .delete-modal-overlay.active {
        display: flex;
    }

    .delete-modal {
        background: white;
        border-radius: 20px;
        padding: 40px 48px;
        max-width: 420px;
        width: 90%;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            transform: scale(0.9) translateY(20px);
            opacity: 0;
        }
        to {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    }

    .delete-modal .modal-icon {
        font-size: 48px;
        color: #dc3545;
        margin-bottom: 16px;
    }

    .delete-modal h3 {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 8px;
    }

    .delete-modal p {
        color: #6c757d;
        font-size: 15px;
        margin-bottom: 24px;
        line-height: 1.6;
    }

    .delete-modal .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .delete-modal .modal-actions .btn-cancel {
        padding: 10px 28px;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        background: transparent;
        color: #6c757d;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .delete-modal .modal-actions .btn-cancel:hover {
        background: #f8f9fa;
        border-color: #dee2e6;
    }

    .delete-modal .modal-actions .btn-confirm-delete {
        padding: 10px 28px;
        border-radius: 10px;
        border: none;
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(220, 53, 69, 0.3);
    }

    .delete-modal .modal-actions .btn-confirm-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(220, 53, 69, 0.4);
    }

    .no-image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        width: 100%;
        background: linear-gradient(145deg, #e9ecef, #f8f9fa);
        color: #adb5bd;
    }

    .no-image-placeholder i {
        font-size: 32px;
        margin-bottom: 4px;
        opacity: 0.4;
    }

    .no-image-placeholder span {
        font-size: 11px;
        font-weight: 500;
    }

    /* ============================================
       PAGINATION
       ============================================ */
    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper .pagination {
        gap: 4px;
    }

    .pagination-wrapper .page-link {
        border-radius: 8px;
        padding: 6px 14px;
        border: none;
        color: #6c757d;
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .pagination-wrapper .page-link:hover {
        background: #800000;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(128,0,0,0.20);
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #800000, #4a0000);
        color: white;
        box-shadow: 0 4px 16px rgba(128,0,0,0.25);
    }

    /* ============================================
       EMPTY STATE
       ============================================ */
    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-state i {
        font-size: 48px;
        color: #800000;
        opacity: 0.2;
        margin-bottom: 16px;
        animation: emptyFloat 3s ease-in-out infinite;
    }

    @keyframes emptyFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .empty-state h4 {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 4px;
    }

    .empty-state p {
        color: #6c757d;
        font-size: 14px;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 768px) {
        .gallery-page-header {
            padding: 35px 20px 28px;
        }

        .gallery-grid-wrapper {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        .header-title-wrapper {
            gap: 14px;
        }

        .header-icon {
            width: 56px;
            height: 56px;
            font-size: 24px;
            border-radius: 16px;
        }

        .title-text {
            font-size: 30px;
        }

        .title-underline {
            width: 50px;
            height: 3px;
        }

        .header-subtitle {
            font-size: 13px;
            gap: 12px;
        }

        .subtitle-line {
            max-width: 40px;
        }

        .gallery-event-card .card-img-wrapper {
            height: 150px;
        }

        .icon-ring:first-of-type { inset: -6px; }
        .ring-2 { inset: -14px; }
        .ring-3 { inset: -22px; }
        
        .btn-edit-event {
            right: 42px;
            width: 28px;
            height: 28px;
            font-size: 12px;
        }
        
        .btn-delete-event {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }
    }

    @media (max-width: 576px) {
        .gallery-page-header {
            padding: 25px 14px 20px;
            border-radius: 14px;
        }

        .gallery-grid-wrapper {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .header-title-wrapper {
            gap: 10px;
            flex-direction: column;
            text-align: center;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
            border-radius: 14px;
        }

        .title-text {
            font-size: 24px;
            text-align: center;
        }

        .title-underline {
            width: 40px;
            height: 2px;
            margin: 6px auto 0;
        }

        .header-subtitle {
            font-size: 11px;
            gap: 8px;
            flex-wrap: wrap;
        }

        .subtitle-text {
            white-space: normal;
            gap: 6px;
        }

        .subtitle-line {
            max-width: 20px;
        }

        .subtitle-icon {
            font-size: 9px;
        }

        .gallery-event-card .card-img-wrapper {
            height: 160px;
        }

        .icon-ring:first-of-type { inset: -4px; }
        .ring-2 { inset: -10px; }
        .ring-3 { inset: -16px; }

        .icon-sparkle {
            font-size: 7px;
        }

        .sparkle-1 {
            top: -6px;
            right: -6px;
        }

        .sparkle-2 {
            bottom: -6px;
            left: -6px;
        }

        .sparkle-3 {
            display: none;
        }

        .btn-edit-event {
            right: 36px;
            width: 26px;
            height: 26px;
            font-size: 11px;
            top: 6px;
        }
        
        .btn-delete-event {
            width: 26px;
            height: 26px;
            font-size: 11px;
            top: 6px;
            right: 6px;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-3">
    <!-- ============================================
         HEADER - WORLD CLASS MAROON & BLACK
         ============================================ -->
    <!-- <div class="gallery-page-header"> -->
        <!-- Animated Background Orbs -->
        <div class="header-orb header-orb-1"></div>
        <div class="header-orb header-orb-2"></div>
        <div class="header-orb header-orb-3"></div>
        <div class="header-orb header-orb-4"></div>
        
        <!-- Gradient Overlay -->
        <div class="header-gradient-overlay"></div>

        <div class="header-content">
            <div class="header-title-wrapper">
                <!-- Icon with Premium Effects -->
                <div class="header-icon-wrapper">
                    <div class="header-icon" style="margin-top: 40px;">
                        <i class="fa fa-images"></i>
                        <div class="icon-glow"></div>
                    </div>
                    <div class="icon-ring"></div>
                    <div class="icon-ring ring-2"></div>
                    <div class="icon-ring ring-3"></div>
                    <div class="icon-sparkle sparkle-1">✦</div>
                    <div class="icon-sparkle sparkle-2">✦</div>
                    <div class="icon-sparkle sparkle-3">✦</div>
                </div>
                
                <!-- Title -->
                <h1 class="header-title">
                    <span class="title-text" style="color:black; margin-top: 20px;">Our Photo Gallery</span>
                    <span class="title-shimmer"></span>
                    <span class="title-underline"></span>
                </h1>
            </div>
            
            <!-- Subtitle -->
            <p class="header-subtitle" style="color:maroon; margin-bottom: 40px;">
                <span class="subtitle-line"></span>
                <span class="subtitle-text" style="color:black;">
                    <i class="fa fa-camera subtitle-icon" style="color:maroon;"></i>
                    Browse our events through photos
                    <i class="fa fa-camera subtitle-icon" style="color:maroon;"></i>
                </span>
                <span class="subtitle-line"></span>
            </p>
        </div>
    <!-- </div> -->

    <!-- ============================================
         GALLERY GRID
         ============================================ -->
    @if($events->count())
        <div class="gallery-grid-wrapper">
            @foreach($events as $event)
                <div class="gallery-event-card">
                    <!-- @php
                        $cover = $event->photos->first();
                        $imageUrl = asset('images/no-image.jpg');
                        $hasImage = false;
                        
                        if ($cover) {
                            $sizes = ['small_path', 'medium_path', 'thumbnail_path', 'original_path'];
                            foreach ($sizes as $size) {
                                if (!empty($cover->$size)) {
                                    $fullPath = public_path($cover->$size);
                                    if (File::exists($fullPath)) {
                                        $imageUrl = asset($cover->$size);
                                        $hasImage = true;
                                        break;
                                    }
                                }
                            }
                        }
                    @endphp -->
						@php
					    $imageUrl = $event->getCoverPhotoUrl();
					    $hasImage = $event->hasCoverPhoto();
					@endphp
                    
                    <div class="card-img-wrapper">
                        @if($hasImage)
                            <img 
                                src="{{ $imageUrl }}" 
                                alt="{{ $event->event_name }}"
                                loading="lazy"
                                onerror="this.style.display='none'; this.parentElement.querySelector('.no-image-placeholder').style.display='flex';">
                        @endif
                        
                        <div class="no-image-placeholder" style="{{ $hasImage ? 'display:none;' : '' }}">
                            <i class="fa fa-image"></i>
                            <span>No Image</span>
                        </div>
                        
                        <div class="image-overlay">
                            <span class="quick-view">
                                <i class="fa fa-images"></i> {{ $event->photos_count }} Photos
                            </span>
                        </div>
                        
                        <span class="image-count">
                            <i class="fa fa-image"></i> {{ $event->photos_count }}
                        </span>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $event->event_name }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($event->description, 70) }}</p>
                        
                        <div class="event-date-location">
                            <div><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</div>
                            <div><i class="fa fa-map-marker"></i> {{ $event->location }}</div>
                        </div>
                        
                        <a href="{{ route('gallery.show', $event->slug) }}" class="btn-view-album">
                            <i class="fa fa-images"></i> View Album ({{ $event->photos_count }})
                        </a>
                    </div>

                    <!-- Edit & Delete Buttons - Admin Only -->
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <button class="btn-edit-event" onclick="editEvent('{{ $event->slug }}')" title="Edit Event">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn-delete-event" onclick="confirmDelete('{{ $event->slug }}', '{{ $event->event_name }}')" title="Delete Event">
                                <i class="fa fa-trash"></i>
                            </button>
                        @endif
                    @endauth
                </div>
            @endforeach
        </div>
       <div class="pagination-wrapper mt-5">
                {{ $events->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="empty-state">
            <i class="fa fa-images"></i>
            <h4>No gallery events found.</h4>
            <p>Check back later for new events.</p>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="delete-modal-overlay" id="deleteModal">
    <div class="delete-modal">
        <div class="modal-icon">
            <i class="fa fa-exclamation-triangle"></i>
        </div>
        <h3>Delete Event</h3>
        <p>Are you sure you want to delete <strong id="deleteEventName"></strong>? This action cannot be undone.</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm-delete">Delete Event</button>
            </form>
        </div>
    </div>
</div>

<script>
function editEvent(eventSlug) {
    window.location.href = "{{ url('/photo-gallery/event') }}/" + eventSlug + "/edit";
}

function confirmDelete(eventSlug, eventName) {
    document.getElementById('deleteEventName').textContent = eventName;
    document.getElementById('deleteForm').action = "{{ url('/photo-gallery/event') }}/" + eventSlug;
    document.getElementById('deleteModal').classList.add('active');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endsection