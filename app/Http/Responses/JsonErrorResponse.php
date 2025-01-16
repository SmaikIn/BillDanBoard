<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class JsonErrorResponse extends JsonResponse
{
    /**
     * JsonErrorResponse constructor.
     *
     * @param  string  $errorMessage
     * @param  int  $status
     * @param  array|null  $headers
     */
    public function __construct(string $errorMessage, int $status = 400, ?array $headers = [])
    {
        $executionTime = microtime(true) - LARAVEL_START;
        $memoryUsed = memory_get_usage();
        $data = [
            'success' => false,
            'data' => [],
            'errors' => [
                [
                    'message' => $errorMessage
                ]
            ],
            'executionTime' => App::environment('testing') ? 0 : round($executionTime, 4),
            'memoryUsed' => App::environment('testing') ? 0 : $this->convert($memoryUsed)
        ];

        parent::__construct($data, $status, $headers);
    }

    private function convert($size): string
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');

        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2).' '.$unit[$i];
    }
}
