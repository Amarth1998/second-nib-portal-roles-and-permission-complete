<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <p>Hello {{ $name }},</p>
    <p>Please click the link below to verify your email:</p>
    <a href="{{ $verificationLink }}">Verify Email</a>
</body>
</html>
