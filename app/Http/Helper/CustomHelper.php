<?php
    function timeZoneConverter($time="", $fromTz='', $toTz=''){
        $time = explode(',', $time);
        $time[1]  = date("H:i:s", strtotime($time[1]));
        $date = new DateTime(implode(' ', $time), new DateTimeZone($fromTz));
        $date->setTimezone(new DateTimeZone($toTz));
        $time= $date->format('Y-m-d H:i:s');
        return $time;
    }