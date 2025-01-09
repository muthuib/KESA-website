<!DOCTYPE html>
<html>
<head>
    <title>Registration Receipt</title>
</head>
<body>
    <h1>Event Registration Receipt</h1>
    <p>Thank you, {{ $registration->name }}!</p>
    <p>You have successfully registered for the event <strong>{{ $event->name }}</strong>.</p>

    <h3>Event Details:</h3>
    <ul>
        <li><strong>Location:</strong> {{ $event->location }}</li>
        <li><strong>Venue:</strong> {{ $event->venue }}</li>
        <li><strong>Date:</strong> {{ $event->start_date }} - {{ $event->end_date }}</li>
    </ul>

    <h3>Your Registration Details:</h3>
    <ul>
        <li><strong>Name:</strong> {{ $registration->name }}</li>
        <li><strong>Email:</strong> {{ $registration->email }}</li>
        <li><strong>Phone:</strong> {{ $registration->phone }}</li>
    </ul>

    <h3>Your QR Code:</h3>
    <div>
        <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
    </div>

    <p>Bring this email and show your QR code at the event entrance.</p>
</body>
</html>
