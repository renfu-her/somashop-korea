<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:payment-check-command')->everyTenMinutes();
Schedule::command('order:check-atm-payment')->everyTenMinutes();
Schedule::command('logistics:check')->everyTenMinutes();
// Schedule::command('email:process')->everyMinute();
// Schedule::command('app:invoice-check-command')->everyTenMinutes();
