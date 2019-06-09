<?php

namespace MetaGameTechnologies\Blog\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Dummy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:dummy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add dummy admin user and data';

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
        $this->info('Adding dummy admin user and data...');
        $this->call('db:seed', ['--class' => 'MetaGameTechnologies\\Blog\\Database\\Seeds\\DatabaseSeeder']);
        $this->info('Dummy data exported.');

        $headers = ['Email', 'Password'];
        $admin = ['admin@example.com', 'secret'];
        $this->table($headers, $admin);
    }
}

