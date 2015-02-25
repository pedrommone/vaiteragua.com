<?php

class WhatsAppQueue {

	public function onGetMessage($mynumber, $from, $id, $type, $time, $name, $body)
	{
		
		Log::info("Message from $name: $body");
	}

	// Refactory and use IoC needed.
	public function fire($job, $data)
	{

		$debug = isset($data['debug']);

		try
		{

			// Path where we store whatsapp data (.dat files)
			$path = storage_path() . '/whatsapp/';

			// Open connection and set things up
			$w = new WhatsProt($_ENV['WPP_NUMBER'], $path . $_ENV['WPP_IDENTITY'], 'Vai ter agua', $debug);

			// Set log messages event
			$w->eventManager()->bind('onGetMessage', function($mynumber, $from, $id, $type, $time, $name, $body)
			{
				
				Log::info("Message from $name: $body");
			});

			$w->setChallengeName($path . 'nextChallenge.dat');
			$w->connect();
			$w->loginWithPassword($_ENV['WPP_PASSWORD']);
			$w->sendActiveStatus();

			// Sync contacs
			$w->sendSync(is_array($data['number']) ? $data['number'] : [$data['number']]);

			// Send presense subscription
			$w->sendPresence();

			// Get messages and log them
			$w->pollMessage();

			// Send message to target
			if (is_array($data['number']))
			{

				foreach ($data['number'] as $target)
				{

					// Send typing command
					$w->sendMessageComposing($target);

					// Human timming
					usleep(rand(700, 1500));

					// Send paused typing
					$w->sendMessagePaused($target);

					// Humans click on send fast? right?
					usleep(rand(200, 600));

					// Finally send it
					$w->sendMessage($target, $data['msg']);

					// Humans click on send fast? right?
					usleep(rand(200, 600));
				}
			}
			else
			{
				
				// Send typing command
				$w->sendMessageComposing($data['number']);

				// Human timming
				usleep(rand(700, 1500));

				// Send paused typing
				$w->sendMessagePaused($data['number']);

				// Humans click on send fast? right?
				usleep(rand(200, 600));

				// Finally send it
				$w->sendMessage($data['number'], $data['msg']);
			}

			// Get messages and log them
			$w->pollMessage();

			// Finish the task
			$w->disconnect();
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
