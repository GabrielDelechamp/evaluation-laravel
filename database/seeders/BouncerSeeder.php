<?php

namespace Database\Seeders;

use Bouncer;
use Illuminate\Database\Seeder;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bouncer::allow('admin')->to('user-create');
        Bouncer::allow('admin')->to('user-retrieve');
        Bouncer::allow('admin')->to('user-delete');

        Bouncer::allow('admin')->to('reservation-create');
        Bouncer::allow('admin')->to('reservation-retrieve');
        Bouncer::allow('admin')->to('reservation-delete');
    }
}
