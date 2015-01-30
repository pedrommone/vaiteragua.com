<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CrawlWatershed extends Command {

	protected $name = 'copasa:watershed';
	protected $description = 'Crawl Watershed from Compasa website.';

	public function __construct()
	{
		
		parent::__construct();
	}

	public function fire()
	{

		$this->info('aaaa');
	
		$client = new \GuzzleHttp\Client();
		$response = $client->get('http://www.copasatransparente.com.br/index.php/nivel-dos-reservatorios/');
		echo ($response->getBody());
	}
}
