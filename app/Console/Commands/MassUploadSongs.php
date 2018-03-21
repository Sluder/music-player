<?php

namespace App\Console\Commands;

use App\Models\Song;
use DirectoryIterator;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class MassUploadSongs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:songs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dir = new RecursiveDirectoryIterator('./public/music/temp');

        foreach (new RecursiveIteratorIterator($dir) as $filename => $file) {
            if (ends_with($filename, "mp3")) {
                $new_file = str_replace(' ', '_', $file->getBasename());
                copy($filename, public_path('music/') . $new_file);

                $getID3 = new \getID3();
                $duration = $getID3->analyze(public_path('music/') . $new_file)['playtime_string'];

                Song::create([
                    'name' =>  explode('.', $new_file)[0],
                    'filename' => $new_file,
                    'length' => $duration
                ]);
            }
        }
    }

}
