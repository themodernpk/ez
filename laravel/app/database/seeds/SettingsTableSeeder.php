<?php


class SettingsTableSeeder extends Seeder
{

	public function run()
	{
		$items = [

			[   'key' => 'login-attemps',
				'group' => 'general',
				'label' => 'Number of login attempts',
				'value' => 3,
				'created_at' => Dates::now(),
				'updated_at' => Dates::now(),
			],
			[   'key' => 'app-name',
				'group' => 'general',
				'label' => 'Application Name',
				'value' => 'WebReinvent App Framework',
				'created_at' => Dates::now(),
				'updated_at' => Dates::now(),
			],
			[   'key' => 'item-per-page',
				'group' => 'general',
				'label' => 'Show paginaion after number of items',
				'value' => 10,
				'created_at' => Dates::now(),
				'updated_at' => Dates::now(),
			],

		];

		DB::table('settings')->insert($items);

	}

}
