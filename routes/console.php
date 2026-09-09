<?php

use App\Models\LoanSchedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('loans:update-overdue', function () {
    $count = LoanSchedule::where('status', 'Pending')
        ->where('due_date', '<', now()->toDateString())
        ->update(['status' => 'Overdue']);
    $this->info("Updated {$count} loan schedules to Overdue.");
})->purpose('Update past-due loan schedules to Overdue status');

Schedule::command('loans:update-overdue')->daily();
