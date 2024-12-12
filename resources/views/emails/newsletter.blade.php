<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <p>{{ $messageContent }}</p>
    <br><br>
    <a href="{{ $unsubscribeLink }}" 
        style="display:inline-block;padding:10px 15px;color:#fff;background-color:#d9534f;border:none;border-radius:5px;text-decoration:none;">
        Unsubscribe
    </a>
</body>
</html>
