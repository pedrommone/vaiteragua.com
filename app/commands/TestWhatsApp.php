<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TestWhatsApp extends Command {

	protected $name = 'wpp:test';
	protected $description = 'Send a delivery test message to target number.';
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		$number = $this->argument('target');

		Queue::push('WhatsAppQueue@fire', [
			"number" => $number,
			"msg" 	=> "This is a test message :)",
			"debug" 	=> true
		]);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{

		return array(
			array('target', InputArgument::REQUIRED, 'Target number without + before number.'),
		);
	}
}
