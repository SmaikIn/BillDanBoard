<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

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
        $data = [
            'success' => false,
            'data' => [],
            'errors' => [
                [
                    'message' => $errorMessage
                ]
            ]
        ];

        parent::__construct($data, $status, $headers);
    }
}
