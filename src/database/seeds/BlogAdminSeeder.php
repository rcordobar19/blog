<?php

namespace MetaGameTechnologies\Blog\Database\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogAdminSeeder extends Seeder
{
    public function run()
    {
        $adminUser = DB::table('users')->where('email', '=', 'admin@example.com')->first();

        if(! $adminUser){
            DB::table('users')->insert([
                'email' => 'admin@example.com',
                'email_verified_at' => Carbon::now(),
                'is_admin' => 1,
                'name' => 'Admin',
                'password' => bcrypt('secret'),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
