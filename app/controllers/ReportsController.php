<?php

class ReportsController extends BaseController {

	public function postSignup()
	{

		// Work around, since eloquent methods ignore mutators.
		Input::merge(['telephone' => str_replace([" ", "-", "(", ")", "+"], "", Input::get('telephone'))]);

		$validator = Validator::make(Input::all(), [
			'number' => 'required'
		]);


		if ( ! $validator->fails())
		{

			$telephone = Telephone::firstOrCreate(['number' => '55' . Input::get('number')]);

			Queue::push('WhatsAppQueue@fire', [
				"number" => "55" . $telephone->number,
				"msg" => "Obrigado por se increver na nossa lista de relatórios!\n\n" .
					    "Precisamos que você valide o seu número, acesse o endereço " . url('/v/' . Hashids::encode($telephone->id)) . " e confirme o seu telefone.\n\n" .
					    "Não se preocupe, não enviamos spam :)"
			]);

			return Response::json([
				'status' => 'ok',
			]);
		}
		else
		{

			return Response::json([
				'status' => 'error',
				'response' => 'Invalid telephone number.',
			]);
		}
	}

	public function getVerify($hash)
	{

		try
		{

			$id = Hashids::decode($hash);

			$telephone = Telephone::findOrFail( (int) $id[0]);
			$telephone->verified_at = new Carbon;
			$telephone->save();

			$thankyou = "Obrigado por se inscrever :). Você pode sair dessa newsletter a qualquer momento, basta acessar o endereço " . url('/r/' . Hashids::encode($telephone->id));

			Queue::push('WhatsAppQueue@fire', [
				"number" => "55" . $telephone->number,
				"msg" => $thankyou
			]);

			return $thankyou;
		}
		catch (Exception $e)
		{

			Log::error($e->getMessage());

			return "Ocorreu algum erro ao verificar o número fornecido.";
		}
	}


	public function getRemove($hash)
	{

		try
		{

			$id = Hashids::decode($hash);

			$telephone = Telephone::findOrFail( (int) $id[0]);

			$thankyou = "Você foi removido com sucesso. Espero que nossos envios tenham sido úteis.";

			Queue::push('WhatsAppQueue@fire', [
				"number" => "55" . $telephone->number,
				"msg" => $thankyou
			]);

			$telephone->delete();

			return $thankyou;
		}
		catch (Exception $e)
		{

			Log::error($e->getMessage());

			return "Ocorreu algum erro ao remover o número fornecido. Caso o erro persista, Mande um e-mail para contato@vaiteragua.com reportando o erro. ;)";
		}
	}
}
