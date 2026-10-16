<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /*
    |--------------------------------------------------------------------------
    | Define the application's command schedule
    |--------------------------------------------------------------------------
    */

    protected function schedule(
        Schedule $schedule
    ): void {
        //
    }


    /*
    |--------------------------------------------------------------------------
    | Register the commands for the application
    |--------------------------------------------------------------------------
    */

    protected function commands(): void
    {
        /*
        |--------------------------------------------------------------------------
        | AUTO LOAD COMMANDS
        |--------------------------------------------------------------------------
        |
        | Semua command di:
        |
        | app/Console/Commands
        |
        | akan otomatis didaftarkan.
        |
        */

        $this->load(
            __DIR__ . '/Commands'
        );


        /*
        |--------------------------------------------------------------------------
        | CONSOLE ROUTES
        |--------------------------------------------------------------------------
        */

        require base_path(
            'routes/console.php'
        );
    }
}