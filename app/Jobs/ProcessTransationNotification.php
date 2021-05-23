<?php

namespace App\Jobs;

use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessTransationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const apiNotificationBaseUri = 'http://o4d9z.mocklab.io/';
    const apiNotificationResourceUri = 'notify';

    protected $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $output = false;

        try{
            $client = new Client(['base_uri' => self::apiNotificationBaseUri]);

            $response = $client->get(self::apiNotificationResourceUri);
            $states = json_decode($response->getBody()->getContents());

            if(data_get($states, 'message') === 'Success'){
                $output = true;
            }

        } catch (\Exception $e){
            Log::error($e->getMessage());
        }

        return $output;
    }
}
