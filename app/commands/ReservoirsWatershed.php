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

	private function parseFromCopasa($xpath)
	{

		try
		{

			// Make request agains Copasa
			$client = new Client();
			$crawler = $client->request('GET', 'http://www.copasatransparente.com.br/index.php/nivel-dos-reservatorios/');
			
			// Filter and get our information
			$crawln = $crawler->filterXPath($xpath)->text();

			// Make use of regex!
			preg_match_all("/(.*)%/", $crawln, $parse_crawln);

			// Format it to US standard
			$parse_crawln = (double) str_replace(',', '.', $parse_crawln[1][0]);

			return $parse_crawln;
		}
		catch (Exception $e)
		{

			$this->error('Error on watershed crawnl procedure: ' . $e->getMessage());
		}
	}

	public function fire()
	{

		try
		{

			// Store xpath and names
			$vessels = [
				'Rio Manso' => '//*[@id="conteudo-principal"]/div[3]/table[1]/tbody/tr[3]/td[4]',
				'Serra Azul' => '//*[@id="conteudo-principal"]/div[3]/table[1]/tbody/tr[4]/td[4]',
				'Vargem das Flores' => '//*[@id="conteudo-principal"]/div[3]/table[1]/tbody/tr[5]/td[4]'
			];

			// Store it on database
			foreach ($vessels as $vessel => $xpath)
			{

				// Parse from copasa
				$status = $this->parseFromCopasa($xpath);

				// Find or creatre a vessel
				$q = $hydrographic_vessel = HydrographicVessel::firstOrCreate([
					'description' => $vessel
				]);

				$q->status()->save(new HydrographicVesselStatus([
					'percentage' => $status
				]));

				$this->info("$vessel has now $status%.");
			}
			
			$this->info(count($vessels) . ' reservoir(s) has been updated');
		}
		catch (Exception $e)
		{

			$this->error('Error on watershed crawnl procedure: ' . $e->getMessage());
		}
	}
}
