<?php


namespace App\Services\Logs;

use App\Models\LogMongo;
use Carbon\Carbon;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class LogHandlerMongo extends AbstractProcessingHandler
{
    public function __construct($level = Logger::DEBUG)
    {
        parent::__construct($level);
    }

    protected function write(array $record):void
    {
        // Simple store implementation
        try{
            $log = new LogMongo();
            $log->fill($record['formatted']);
            $log->created_at = Carbon::now();
            $log->save();
        }catch (\Exception $e){
            error_log(PHP_EOL.$e->getMessage(),3,storage_path('logs/integra_'.date('Y_m_d').'.log'));
        }
        // Queue implementation
    }
    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new LogFormatter();
    }


}
