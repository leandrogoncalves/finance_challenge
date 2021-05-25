<?php


namespace App\Services;


use App\Models\Transaction;
use App\Services\Contracts\PaymentAuthorizationInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PaymentAutorizationService implements PaymentAuthorizationInterface
{
    const apiAuthorizationBaseUri = 'https://run.mocky.io/';
    const apiAuthorizationResourceUri = 'v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isAuthorized(Transaction $transaction):bool
    {
        $output = false;

        try{
            $client = new Client(['base_uri' => self::apiAuthorizationBaseUri]);

            $response = $client->get(self::apiAuthorizationResourceUri.'?transaction_id='.$transaction->id);
            $states = json_decode($response->getBody()->getContents());

            if(data_get($states, 'message') === 'Autorizado'){
                $output = true;
            }

        } catch (\Exception $e){
            Log::error($e->getMessage());
        }

        return $output;
    }
}
