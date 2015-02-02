<?php

use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ReservoirsWatershed extends Command {

	protected $name = 'copasa:reservoirs';
	protected $description = 'Crawl reservoirs status from Compasa website.';

	public function __construct()
	{
		
		parent::__construct();
	}

	public function fire()
	{

		try
		{

			$crawln_vessels = [];

			// Make request agains Copasa
			$client = new Client();
			$crawler = $client->request('GET', 'http://www.copasatransparente.com.br/index.php/nivel-dos-reservatorios/');
			
			// Filter and get our information
			$crawln = $crawler->filterXPath('//*[@id="post-24"]/div/div[2]/div[1]/ul[1]/li/strong')->each(function(Crawler $node, $i) use (&$crawln_vessels)
			{

				// Make a regex and get usable data.
				preg_match_all("/(.*): (.*)%/", $node->text(), $parse_crawln);
				
				$crawln_vessels[] = [
					'description' => $parse_crawln[1][0],
					'percentage' => $parse_crawln[2][0]
				];
			});

			// Store it on database
			foreach ($crawln_vessels as $vessel)
			{

				// Find or creatre a vessel
				$q = $hydrographic_vessel = HydrographicVessel::firstOrCreate([
					'description' => $vessel['description']
				]);

				$q->status()->save(new HydrographicVesselStatus([
					'percentage' => $vessel['percentage']
				]));
			}

			$this->info(count($crawln_vessels) . ' eservoir(s) has been updated');
		}
		catch (Exception $e)
		{

			$this->error('Error on watershed clawln procedure: ' . $e->getMessage());
		}
	}
}
