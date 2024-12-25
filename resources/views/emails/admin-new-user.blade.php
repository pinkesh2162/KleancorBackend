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
       
    </style>
</head>
<body>
    <div class="email-container">
        <div class="content">
            <p>New user {{ $user->first_name }} {{$user->last_name}} registed in {{ config('app.name') }}.</p>
            <p><b>Email:</b> {{ $user->email }}</p>
            <p><b>Phone:</b> {{ $user->contact }}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
