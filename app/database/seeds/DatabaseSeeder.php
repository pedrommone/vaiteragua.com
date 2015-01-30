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

		HydrographicVessel::insert([
			['description' => 'Rio Manso'],
			['description' => 'Serra Azul'],
			['description' => 'Vargem das Flores']
		]);

		$this->command->info('Added initial vessels.');
	}

}
