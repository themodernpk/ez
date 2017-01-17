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

		$seed_path = app_path()."/database/seeds";
		$scan_seeds = scan_dir_paths($seed_path);



		foreach($scan_seeds as $seed)
		{

			$seed = str_replace(".php", "", $seed);
			$seed = str_replace("$seed_path", "", $seed);
			$seed = str_replace('\\', '', $seed);


			if (strpos($seed,'/') !== false) {
				$seed = str_replace('/', '', $seed);
			}

			if($seed == 'DatabaseSeeder')
			{
				continue;
			}

			$this->call($seed);

		}

		Custom::syncPermissions();
	}

}
