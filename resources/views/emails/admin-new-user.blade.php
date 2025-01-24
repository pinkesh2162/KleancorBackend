<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kleancor Email Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            color: #ffffff;
            text-align: center;
            position: relative;
        }

        .header img {
            width: 100%;
        }

        .header .btn {
            position: absolute;
            top: 30px;
            right: 30px;
            background-color: #ffffff;
            color: #000;
            padding: 10px 30px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background-color: #f0f0f0;
        }

        .content {
            padding: 20px;
            color: #333333;
        }

        .content .head {
            font-size: 26px;
            color: #333333;
        }

        .content p {
            margin: 15px 0;
            line-height: 1.6;
        }

        .content strong {
            font-weight: bold;
        }

        .contact {
            margin-top: 20px;
            color: #333333;
        }

        .contact p {
            margin: 5px 0;
        }

        .contact a {
            color: #004aab;
            text-decoration: none;
        }

        .help-section {
            margin-top: 20px;
            color: #333333;
            text-align: center;
        }

        .help-section a {
            color: #004aab;
            text-decoration: none;
        }

        .help-section p {
            margin: 0;
        }

        .footer {
            background-color: #333dd0;
            color: #ffffff;
            padding: 10px 20px;
            font-size: 14px;
        }

        .footer a {
            color: #ffffff;
            text-decoration: underline;
        }

        .brand-section {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            margin-bottom: 30px;
        }

        .brand-logo {
            padding: 5px 20px;
            font-size: 20px;
        }
    </style>
</head>

<body style="font-family:Arial, sans-serif;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;background-color:#f8f8f8;">
    <div class="container" style="max-width:600px;margin-top:20px;margin-bottom:20px;margin-right:auto;margin-left:auto;background-color:#ffffff;border-radius:10px;box-shadow:0 4px 6px rgba(0, 0, 0, 0.1);overflow:hidden;">
        <div class="header" style="color:#ffffff;text-align:center;position:relative;">
            <img src="{{ url('assets/images/email/email-header.png') }}" alt="Kleancor Logo" style="width:100%;">
        </div>
        <div class="content" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;color:#333333;">
            <p style="margin-top:15px;margin-bottom:15px;margin-right:0;margin-left:0;line-height:1.6;">New subscription at Kleancor</p>
            <p style="margin-top:15px;margin-bottom:15px;margin-right:0;margin-left:0;line-height:1.6;">Hello Kleancor Team!</p>
            <p style="margin-top:15px;margin-bottom:15px;margin-right:0;margin-left:0;line-height:1.6;">A new user has registered or a new service
                request has been made on the platform</p>
            <p style="margin-top:15px;margin-bottom:15px;margin-right:0;margin-left:0;line-height:1.6;">
                User details as a <b>customer:</b>
            </p>
            <p style="color:#939b9d;margin-top:15px;margin-bottom:15px;margin-right:0;margin-left:0;line-height:1.6;">
                Name: {{$user->first_name}} {{$user->last_name}}<br />
                Email: {{$user->email}}<br />
                Phone: {{@$user->contact}}<br />
                Address: {{$user->address}}<br />
            </p>
            <p style="margin-top:50px;margin-bottom:0;margin-right:0;margin-left:0;line-height:1.6;">
                Greetings,<br>
                Automatic Notifications Team<br>
                KLEANCOR
            </p>
        </div>
        <div class="footer" style="background-color:#333dd0;color:#ffffff;padding-top:10px;padding-bottom:10px;padding-right:20px;padding-left:20px;font-size:14px;">
            <div class="brand-section" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#ddd;padding-top:10px;padding-bottom:10px;padding-right:0;padding-left:0;margin-bottom:30px;">
                <a href="https://www.facebook.com/people/KleanCor-Inc/100069907939852/?mibextid=LQQJ4d" class="brand-logo" style="padding-left:0;padding-top:5px;padding-bottom:5px;padding-right:20px;font-size:20px;color:#ffffff;text-decoration:underline;"><img width="30" height="30" src="https://img.icons8.com/ios-filled/50/FFFFFF/facebook--v1.png" alt="facebook--v1" /></a>
                <a href="https://x.com/kleancorinc" class="brand-logo" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;font-size:20px;color:#ffffff;text-decoration:underline;"><img width="30" height="30" src="https://img.icons8.com/ios-filled/50/FFFFFF/twitter.png" alt="twitter" /></a>
                <a href="https://www.instagram.com/kleancor_inc/" class="brand-logo" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;font-size:20px;color:#ffffff;text-decoration:underline;"><img width="30" height="30" src="https://img.icons8.com/ios-filled/50/FFFFFF/instagram-new--v1.png" alt="instagram-new--v1" /></a>
                <a href="https://www.linkedin.com/in/kleancor-inc-429bb9335/" class="brand-logo" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;font-size:20px;color:#ffffff;text-decoration:underline;"><img width="30" height="30" src="https://img.icons8.com/ios-filled/50/FFFFFF/linkedin.png" alt="linkedin" /></a>
            </div>
            <p style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;">© 2024 Kleancor. All rights reserved. | <a href="#" style="color:#ffffff;text-decoration:underline;">Disclaimers & Policies</a></p>
        </div>
    </div>
</body>

</html>