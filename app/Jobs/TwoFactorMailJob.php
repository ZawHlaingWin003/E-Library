<?php

namespace App\Jobs;

use App\Mail\TwoFactorCodeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class TwoFactorMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $two_factor_code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($two_factor_code)
    {
        $this->two_factor_code = $two_factor_code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to('taylor@example.com')->send(new TwoFactorCodeMail('123456'));
        // Mail::to('hi@gmail.com')->send(new TwoFactorCodeMail($this->two_factor_code));
    }

    public function failed(Throwable $exception): void
    {
        // Send user notification of failure, etc...
    }
}
