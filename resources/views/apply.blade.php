<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $applyNotification['title'] }}</title>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .header {
            background-color: #03B7EA;
            color: #fff;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .content {
            padding: 20px;
            background-color: #f3f3f3;
        }

        .content p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .footer {
            background-color: #03B7EA;
            color: #fff;
            padding: 20px;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ $applyNotification['title'] }}</h1>
        </div>
        <div class="content">
            <p>Dear {{ $applyNotification['name'] }},</p>
            <p>{{ $applyNotification['message'] }}</p>
        </div>
        <div class="footer">
            <p>Best regards,</p>
            <p>The KleanCor Team</p>
        </div>
    </div>

</body>

</html>