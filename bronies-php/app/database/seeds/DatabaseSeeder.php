<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		DB::table('bronies')->delete();

		Bronie::create(array( 'name'      => 'Yehuda Katz',
		                      'email'     => 'yehuda@emberjs.com',
		                      'pony_name' => 'Apple Star' ));
		Bronie::create(array( 'name'      => 'Tom Dale',
		                      'email'     => 'tom@emberjs.com',
		                      'pony_name' => 'Blade Thunder' ));
		Bronie::create(array( 'name'      => 'Peter Wagenet',
		                      'email'     => 'peter@emberjs.com',
		                      'pony_name' => 'Strong Gunner' ));
		Bronie::create(array( 'name'      => 'Trek Glowacki',
		                      'email'     => 'trek@emberjs.com',
		                      'pony_name' => 'Veiled Steel' ));
		Bronie::create(array( 'name'      => 'Erik Bryn',
		                      'email'     => 'erik@emberjs.com',
		                      'pony_name' => 'Defiant Perfection' ));
		Bronie::create(array( 'name'      => 'Kris Seldon',
		                      'email'     => 'kris@emberjs.com',
		                      'pony_name' => 'Magical Drop' ));
		Bronie::create(array( 'name'      => 'Stefan Penner',
		                      'email'     => 'stefan@emberjs.com',
		                      'pony_name' => 'Heroic Fire' ));
		Bronie::create(array( 'name'      => 'Leah Silber',
		                      'email'     => 'leah@emberjs.com',
		                      'pony_name' => 'Radiant Aura' ));
		Bronie::create(array( 'name'      => 'Alex Matchneer',
		                      'email'     => 'alex@emberjs.com',
		                      'pony_name' => 'Midnight Rainbow' ));
		Bronie::create(array( 'name'      => 'Robert Jackson',
		                      'email'     => 'robert@emberjs.com',
		                      'pony_name' => 'Charged Sprout' ));

		$this->command->info('Bronie table seeded!');
	}

}
