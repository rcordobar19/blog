<?php

namespace MetaGameTechnologies\Blog\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Blog Installation';

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
        $this->info('Installation started...');

        $this->call('make:auth');
        $this->call('vendor:publish', ['--force' => 'true', '--provider' => 'MetaGameTechnologies\Blog\BlogServiceProvider']);
        $this->call('migrate');
        $this->call('db:seed', ['--class' => 'MetaGameTechnologies\\Blog\\Database\\Seeds\\DatabaseSeeder']);

        $this->info('Done.');
    }
}

