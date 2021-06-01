<?php


namespace App\Services;


use App\Models\Transaction;
use App\Services\Contracts\NotificationServiceInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class NotificationService implements NotificationServiceInterface
{
    const apiNotificationBaseUri = 'http://o4d9z.mocklab.io/';
    const apiNotificationResourceUri = 'notify';

    public function notifyTransaction(Transaction $transaction)
    {
        $output = false;

        try{
            $client = new Client(['base_uri' => self::apiNotificationBaseUri]);

            $response = $client->get(self::apiNotificationResourceUri);
            $states = json_decode($response->getBody()->getContents());

            if(data_get($states, 'message') === 'Success'){
                $output = true;
                Log::info('User notified');
            }

        } catch (\Exception $e){
            Log::error($e->getMessage());
        }

        return $output;
    }
}
