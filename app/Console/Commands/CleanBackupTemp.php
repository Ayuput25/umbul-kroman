<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanBackupTemp extends Command
{
    protected $signature =
        'backup:clean-temp';

    protected $description =
        'Membersihkan temporary backup dan restore Umbul Kroman';

    public function handle(): int
    {
        $directories = [
            storage_path('app/backup-temp'),
            storage_path('app/restore-temp'),
        ];

        $removed = 0;


        foreach ($directories as $directory) {

            if (!File::isDirectory($directory)) {
                continue;
            }


            foreach (
                File::directories($directory)
                as $childDirectory
            ) {
                $lastModified =
                    File::lastModified(
                        $childDirectory
                    );


                /*
                |--------------------------------------------------------------------------
                | HAPUS TEMP > 24 JAM
                |--------------------------------------------------------------------------
                */

                if (
                    $lastModified
                    < now()
                        ->subDay()
                        ->timestamp
                ) {
                    File::deleteDirectory(
                        $childDirectory
                    );

                    $removed++;
                }
            }
        }


        $this->info(
            $removed
            . ' temporary backup directory dibersihkan.'
        );


        return self::SUCCESS;
    }
}