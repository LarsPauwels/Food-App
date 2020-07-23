<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
    	$role1 = new \App\Role();
        $role1->name = 'Admin';
        $role1->description = $faker->realText(191);
        $role1->save();

        $role2 = new \App\Role();
        $role2->name = 'Company';
        $role2->description = $faker->realText(191);
        $role2->save();

        $role2 = new \App\Role();
        $role2->name = 'Employee';
        $role2->description = $faker->realText(191);
        $role2->save();

        $role2 = new \App\Role();
        $role2->name = 'Supplier';
        $role2->description = $faker->realText(191);
        $role2->save();

        //factory(\App\Roles::class, 5)->create();
    }
}
