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

<body style="font-family:Arial, sans-serif;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;background-color:#f8f8f8;">
    <div class="container" style="max-width:600px;margin-top:20px;margin-bottom:20px;margin-right:auto;margin-left:auto;background-color:#ffffff;border-radius:10px;box-shadow:0 4px 6px rgba(0, 0, 0, 0.1);overflow:hidden;">
        <div class="header" style="color:#ffffff;text-align:center;position:relative;">
            <img src="{{ url('assets/images/email/email-header.png') }}" alt="Kleancor Logo" style="width:100%;">
            <a href="https://kleancor.com/" class="btn" style="position:absolute;top:30px;right:30px;background-color:#ffffff;color:#000;padding-top:10px;padding-bottom:10px;padding-right:30px;padding-left:30px;font-size:16px;font-weight:bold;text-decoration:none;border-radius:20px;box-shadow:0 2px 4px rgba(0, 0, 0, 0.1);">Try it now</a>
        </div>
        <div class="content" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;color:#333333;">
            <p class="head" style="margin-top:15px;margin-bottom:15px;margin-right:0;margin-left:0;line-height:1.6;font-size:26px;color:#333333;">Welcome to Kleancor!</p>
            <p style="margin-top:15px;margin-bottom:15px;margin-right:0;margin-left:0;line-height:1.6;">Hi {{$user->first_name}} {{$user->last_name}},</p>
            <p style="margin-top:15px;margin-bottom:15px;margin-right:0;margin-left:0;line-height:1.6;">Thank you for joining our platform. We are glad that you are part of our community.</p>
            <p style="margin-top:15px;margin-bottom:15px;margin-right:0;margin-left:0;line-height:1.6;">
                With more than 20 years of experience, we guarantee an
                exceptional quality standard supervised in each service.
            </p>
            <p style="margin-top:15px;margin-bottom:15px;margin-right:0;margin-left:0;line-height:1.6;">We specialize in adapting our work to your specific needs, always exceeding your expectations.</p>
            <div class="contact" style="margin-top:20px;color:#333333;">
                <p style="text-align:center;line-height:1.6;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">If you have any questions or need assistance,</p>
                <p style="text-align:center;line-height:1.6;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">please feel free to contact us:</p>
                <p style="line-height:1.6;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;"><img width="16" height="16"
                        src="https://img.icons8.com/ios-filled/50/1A1A1A/phone.png" alt="phone" style="vertical-align:text-top;" /> (800) 988-6838</p>
                <p style="line-height:1.6;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">
                    <img width="16" height="16"
                        src="https://img.icons8.com/ios-filled/50/1A1A1A/new-post.png" alt="new-post" style="vertical-align:text-top;" />
                    kleancor.com@gmail.com
                </p>
                <p style="line-height:1.6;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">
                    <img width="16" height="16"
                        src="https://img.icons8.com/ios-filled/50/1A1A1A/marker.png" alt="marker" style="vertical-align:text-top;" /> 1445 Montier St,
                    Pittsburgh, PA 15221
                </p>
            </div>
            <div class="help-section" style="margin-top:20px;color:#333333;text-align:center;">
                <p style="line-height:1.6;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;"><b>Need help?</b></p>
                <a href="https://kleancor.com/" style="color:#004aab;text-decoration:none;">kleancor.com</a>
                <p style="line-height:1.6;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;"><b>for more information.</b></p>
            </div>
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