<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

	public function run()
	{

		\App\User::create([
			'family_name' 	     => 'John',
			'last_name'   => 'Doe',
			'username'   => 'admin',
			'email'		 => 'admin@cloudmlmsoftware.com',
			'status' 	 => 0,
			'mobile'	 => '123456789',
			'password'	 => bcrypt('admin'),
			'join_date'  => date('y-m-d'),
			'upline_id'  => 0,
			'level_no'	 => 1,	
		]);	


	

	}

}
