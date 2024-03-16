<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        $data = [
            'success' => !count($errors) && $status !== Response::HTTP_NOT_FOUND,
            'data' => $data,
            'errors' => $errors
        ];

        $canAddDebugBarInfo = config('app.env') !== 'production' && app()->bound('debugbar') && app('debugbar')->isEnabled();
        if ($canAddDebugBarInfo) {
            $data['__debugbar'] = app('debugbar')->getData();
        }

        parent::__construct($data, $status, $headers);
    }
}
