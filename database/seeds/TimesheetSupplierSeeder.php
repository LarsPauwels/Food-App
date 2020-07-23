<?php

use Illuminate\Database\Seeder;

class TimesheetSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Timesheet_Supplier::class, 5)->create();
    }
}
