<?php
function timeZoneConverter($time = "", $fromTz = '', $toTz = '')
{
    $time = explode(',', $time);
    $time[1]  = date("H:i:s", strtotime($time[1]));
    $date = new DateTime(implode(' ', $time), new DateTimeZone($fromTz));
    $date->setTimezone(new DateTimeZone($toTz));
    $time = $date->format('Y-m-d H:i:s');
    return $time;
}

if (!function_exists('setEmailConfiguration')) {
    function  setEmailConfiguration()
    {
        config([
            'mail.mailers.smtp.host' => 'kleancor.app',
            'mail.mailers.smtp.port' => 587,
            'mail.mailers.smtp.username' => 'support@kleancor.app',
            'mail.mailers.smtp.password' => 'Kleancor@123',
            'mail.mailers.smtp.encryption' => 'tls',
            'mail.from.address' => 'support@kleancor.app',
            'mail.from.name' => config('app.name'),
        ]);
    }
}
