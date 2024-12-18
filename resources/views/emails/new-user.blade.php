<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Kleancor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            text-align: center;
            padding: 10px 0;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            text-align: left;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            font-size: 12px;
            color: #777;
        }
        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome to Kleancor</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user->first_name }} {{$user->last_name}},</p>
            <p>Thank you for registering with us! We’re excited to have you on board.</p>
            <p>If you have any questions, feel free to reach out to our support team.</p>
            <p>Best regards,</p>
            <p>The {{ config('app.name') }} Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
