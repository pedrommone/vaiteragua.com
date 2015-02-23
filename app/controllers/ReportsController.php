<?php

class ReportsController extends BaseController {

	public function postSignup()
	{

		$validator = Validator::make(Input::all(), [
			'number' => 'required'
		]);


		if ( ! $validator->fails())
		{

			$telephone = Telephone::firstOrCreate(['number' => Input::get('number')]);

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

			$telephone = Telephone::findOrFail( (int) $id);
			$telephone->verified_at = new Carbon;
			$telephone->save();

			$thankyou = "Obrigado por se inscrever :). Você pode sair dessa newsletter a qualquer momento, basta acessar o endereço " . url('/reports/' . Hashids::encode($telephone->id) . '/remove');

			Queue::push('WhatsAppQueue@fire', [
				"number" => "55" . $telephone->number,
				"msg" => $thankyou
			]);

			return $thankyou;
		}
		catch (Exception $e)
		{

			Log::error($e->getMessage());

			return "Ocorrou algum erro ao verificar o número fornecido.";
		}
	}


	public function getRemove($hash)
	{

		try
		{

			$id = Hashids::decode($hash);

			$telephone = Telephone::findOrFail( (int) $id)
				->delete();

			$thankyou = "Você foi removido com sucesso. Espero que nossos envios tenham sido úteis.";

			Queue::push('WhatsAppQueue@fire', [
				"number" => "55" . $telephone->number,
				"msg" => $thankyou
			]);

			return $thankyou;
		}
		catch (Exception $e)
		{

			Log::error($e->getMessage());

			return "Ocorrou algum erro ao remover o número fornecido.";
		}
	}
}
