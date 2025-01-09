<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationReceiptMail;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class RegistrationController extends Controller
{
    public function create(Event $event)
    {
        return view('registrations.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|regex:/^2547\d{8}$/',
        ]);

        $registration = Registration::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Generate QR Code using Bacon QR Code
        $qrData = json_encode([
            'name' => $registration->name,
            'email' => $registration->email,
            'event_id' => $event->id,
            'registration_id' => $registration->id,
        ]);

        // Setup renderer for PNG output
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new \BaconQrCode\Renderer\Image\ImagickImageBackEnd() // This assumes Imagick is installed. You can also use GD
        );

        // Create the writer
        $writer = new Writer($renderer);

        // Generate the QR code as a PNG
        $qrPath = 'qrcodes/' . $registration->id . '.png';
        $writer->writeFile($qrData, public_path($qrPath));

        // Update registration with QR code path
        $registration->update(['qr_code_path' => $qrPath]);

        // Send the email with the QR code
        Mail::to($registration->email)->send(new RegistrationReceiptMail($registration, $event, $qrPath));

        // Return the success view
        return view('registrations.success', compact('registration', 'event'));
    }
}

