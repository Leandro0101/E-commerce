<?php

require_once "StatesTableSeeder.php";
require_once "CitiesTableSeeder.php";

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
    }
}