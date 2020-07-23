<?php

use Illuminate\Database\Seeder;

class TimesheetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Timesheet::class, 5)->create();
    }
}
