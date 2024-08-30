<?php

namespace App\RestApi;

class ApiResponseBuilder
{
    private ApiResponse $apiResponse;

    public function __construct()
    {
        $this->apiResponse = new ApiResponse();
    }

    public function withMessage(string $message)
    {
        $this->apiResponse->setMessage($message);
        return $this;
    }

    public function withData(mixed $data)
    {
        $this->apiResponse->setArray($data);
        return $this;
    }

    public function withStatus(int $status = 200)
    {
        $this->apiResponse->setStatus($status);
        return $this;
    }

    public function withAppends(array $appends)
    {
        $this->apiResponse->setAppends($appends);
        return $this;
    }

    public function build()
    {
        return $this->apiResponse;
    }
}
