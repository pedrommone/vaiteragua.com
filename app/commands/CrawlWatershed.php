<?php

use Goutte\Client;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
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

		try
		{

			// Make request agains Copasa
			$client = new Client();
			$crawler = $client->request('GET', 'http://www.copasatransparente.com.br/index.php/nivel-dos-reservatorios/');
			
			// Filter and get our information
			$crawln = $crawler->filterXPath('//*[@id="conteudo-principal"]/div[3]/table[1]/tbody/tr[2]/td[4]')->text();

			// Make use of regex!
			preg_match_all("/(.*)%/", $crawln, $parse_crawln);

			// Format it to US standard
			$parse_crawln = (double) str_replace(',', '.', $parse_crawln[1][0]);

			// Now, lets store it into our database.
			$watershed_status = new WatershedStatus;
			$watershed_status->percentage = $parse_crawln;
			$watershed_status->save();

			$this->info('Watershed status updated, now is ' . $parse_crawln . '%.');
		}
		catch (Exception $e)
		{

			$this->error('Error on watershed crawnl procedure: ' . $e->getMessage());
		}
	}
}
