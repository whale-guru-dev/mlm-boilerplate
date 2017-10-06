<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

	public function run()
	{

		\App\User::create([
			'name' 	     => 'John',
			'lastname'   => 'Doe',
			'username'   => 'admin',
			'email'		 => 'admin@cloudmlmsoftware.com',
			'binary_qualification' => 'no',
			'dateofbirth'=> '15/01/1984',
			'rank_id'=> '1',
			'password'   => bcrypt('admin123'),
			'confirmed'  => 1,
            'admin'      => 1,
            'about'      => "",
            'my_package'      => 0,
			'confirmation_code' => md5(microtime() . env('APP_KEY')),
		]);	

		\App\User::create([
			'name' 	     => 'Jessica',
			'lastname'   => 'Doe',
			'username'   => 'user',
			'email'		 => 'user@cloudmlmsoftware.com',
			'binary_qualification' => 'no',
			'dateofbirth'=> '15/01/1984',
			'rank_id'=> '1',
			'password'   => bcrypt('user123'),
			'confirmed'  => 1,
            'admin'      => 0,
            'about'      => "",
            'my_package'      => 1,
			'confirmation_code' => md5(microtime() . env('APP_KEY')),
		]);	
	

	}

}
