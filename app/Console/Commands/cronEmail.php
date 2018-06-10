<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class cronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea notificaciones para los usuarios';

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
      $notify = DB::table('oficinas')->insert([
        'nombre'=>rand(0,100).'_My Office',
      ]);
      //$this->info('hello Romel');
    }
}
