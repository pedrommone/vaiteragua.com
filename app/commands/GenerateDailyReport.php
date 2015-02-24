<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateDailyReport extends Command {

	protected $name = 'reports:daily';
	protected $description = 'Send daily reports to everyone at database.';

	public function fire()
	{
		
		$two_last_general = WatershedStatus::
			    orderBy('created_at', 'desc')
			->take(2)
			->get();

		if (count($two_last_general) < 2)
		{

			return false;
		}

		$general_newest = $two_last_general[0];
		$general_oldest = $two_last_general[1];

		$general_diff = (double) $general_newest->percentage - (double) $general_oldest->percentage;
		$today = $general_newest->created_at->format("d/m/Y");
		$yesterday = $general_oldest->created_at->format("d/m/Y");
		$current = $general_newest->percentage;

		$msg = "";

		if ($general_newest->percentage > $general_oldest->percentage)
		{

			$msg = "Subimos! Na contabilidade de hoje $today subimos $general_diff ponto(s) percentuais \o/. Estamos com o reservatório com $current%.";
		}

		if ($general_newest->percentage == $general_oldest->percentage)
		{

			$msg = "Manteve! Estamos parados em relação à ontem ($yesterday) com $current%.";
		}

		if ($general_newest->percentage < $general_oldest->percentage)
		{

			$msg = "Caiu! Ajude na campanha, compartilhe! Perdemos $general_diff ponto(s) percentuais.";
		}

		$targets = Telephone::
			    whereNotNull("verified_at")
			->get()
			->toArray();

		// Split it into 10 messages per row
		foreach(array_chunk($targets, 10, true) as $index => $target)
		{

			$time = Carbon::now()->addMinutes($index);

			foreach ($target as $telephone)
			{
			
				Queue::later($time, 'WhatsAppQueue@fire', [
					"number" => "55" . $telephone['number'],
					"msg" => $msg
				]);
			}
		}
	}
}
