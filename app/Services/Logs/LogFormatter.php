<?php


namespace App\Services\Logs;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Monolog\Formatter\NormalizerFormatter;

class LogFormatter extends NormalizerFormatter
{
    /**
     * type
     */
    const LOG = 'log';
    const STORE = 'store';
    const CHANGE = 'change';
    const DELETE = 'delete';
    /**
     * result
     */
    const SUCCESS = 'success';
    const NEUTRAL = 'neutral';
    const FAILURE = 'failure';
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        $record = parent::format($record);
        return $this->getDocument($record);
    }
    /**
     * Convert a log message into an Mongo Log entity
     * @param array $record
     * @return array
     */
    protected function getDocument(array $record)
    {
        $fills = $record['extra'];
        $fills['message'] = $record['message'];
        $fills['level'] = Str::lower($record['level']);
        $fills['token'] = Str::random(30);
        $fills['host'] = getenv('URL')?getenv('URL'):request()->getHost();
        $fills['url'] = request()->fullUrl();
        $context = $record['context'];
        if (!empty($context)) {
            $fills['type'] = data_get($context, 'type', self::LOG);
            $fills['result'] = Arr::has($context, 'result')  ? $context['result'] : self::NEUTRAL;
            $fills = array_merge($fills, $record['context']);
        }
        return $fills;
    }
}
