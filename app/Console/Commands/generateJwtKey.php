<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class generateJwtKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generateJwt:key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a JWT Key';

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
     * @return int
     */
    public function handle()
    {
        if(env('JWT_SECRET')){
            $this->info('JWT key already registered.');
        }else{
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 39; $i++) {
                $randomString .= $characters[Rand(0, $charactersLength - 1)];
            }
            file_put_contents($this->laravel->environmentFilePath(),
                'JWT_SECRET="'.$randomString.'"',
                FILE_APPEND
            );
            $this->info('JWT key set successfully.');
        }
    }
}
