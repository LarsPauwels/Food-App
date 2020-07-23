<?php

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
    	$this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(AddressesSeeder::class);
        $this->call(TimesheetsSeeder::class);
        $this->call(AdminsSeeder::class);
        $this->call(DetailsSeeder::class);
        $this->call(SuppliersSeeder::class);
        $this->call(CompaniesSeeder::class);
        $this->call(EmployeesSeeder::class);
        $this->call(OrdersSeeder::class);
        $this->call(ToppingsSeeder::class);
        $this->call(BasesSeeder::class);
        $this->call(BaseOrdersSeeder::class);
        $this->call(CurrenciesSeeder::class);
        $this->call(BaseOrderToppingsSeeder::class);
        $this->call(TimesheetSupplierSeeder::class);
    }
}
