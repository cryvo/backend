<?php
$interval = Setting::get('crybot.schedule_interval', 'everyMinute');
$schedule->command('crybot:scan')
         ->{$interval}()        // dynamic method call
         ->withoutOverlapping();
