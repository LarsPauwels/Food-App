<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user1 = new \App\User();
        $user1->email = 'lars.pauwels@telenet.be';
        $user1->password = '$2y$10$W6zQcJJxHK4be3.z2S.iUe36JKXepph90UiWfnN/SICQOASG1q6K2';
        $user1->remember_token = Str::random(10);
        $user1->role_id = 1;
        $user1->save();

       	factory(\App\User::class, 50)->create();
    }
}
