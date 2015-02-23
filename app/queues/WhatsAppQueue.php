<?php

class WhatsAppQueue {

	// Refactory and use IoC needed.
	public function fire($job, $data)
	{

		try
		{

			// Path where we store whatsapp data (.dat files)
			$path = storage_path() . '/whatsapp/';

			// Open connection and set things up
			$w = new WhatsProt($_ENV['WPP_NUMBER'], $path . $_ENV['WPP_IDENTITY'], 'Vai ter agua', false);
			
			$w->setChallengeName($path . 'nextChallenge.dat');
			$w->connect();
			$w->loginWithPassword($_ENV['WPP_PASSWORD']);

			// Send message to target
			$w->sendMessage($data['number'] , $data['msg']);

			$job->delete();
		}
		catch (Exception $e)
		{

			Log::error($e->getMessage());

			if ($job->attempts() > 3)
			{
			 
			 	$job->delete();
			}
			else
			{

				$job->release(30);
			}
		}
	}
}
