<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class JsonApiResponse extends JsonResponse
{
    /**
     * JsonAPIResponse constructor.
     *
     * @param  array  $data
     * @param  array  $errors
     * @param  int  $status
     * @param  array|null  $headers
     */
    public function __construct(array $data, array $errors = [], int $status = 200, ?array $headers = [])
    {
        $executionTime = microtime(true) - LARAVEL_START;
        $memoryUsed = memory_get_usage();

        $data = [
            'success' => !count($errors) && $status !== Response::HTTP_NOT_FOUND,
            'data' => $data,
            'errors' => $errors,
            'executionTime' => App::environment('testing') ? 0 : round($executionTime, 4),
            'memoryUsed' => App::environment('testing') ? 0 : $this->convert($memoryUsed)
        ];

        $canAddDebugBarInfo = config('app.env') !== 'production' && app()->bound('debugbar') && app('debugbar')->isEnabled();
        if ($canAddDebugBarInfo) {
            $data['__debugbar'] = app('debugbar')->getData();
        }

        parent::__construct($data, $status, $headers);
    }

    private function convert($size): string
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');

        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2).' '.$unit[$i];
    }
}
