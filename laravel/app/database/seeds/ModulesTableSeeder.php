<?php

class ModulesTableSeeder extends Seeder {

	public function run()
	{
		$items = [

			[   'name' => 'core',
				'version' => '1.0',
				'active' => 1,
				'created_at' => Dates::now(),
				'updated_at' => Dates::now(),
			]

		];

		DB::table('modules')->insert($items);


	}

}
