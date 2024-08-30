<?php

namespace App\RestApi;

use http\Message\Body;

class ApiResponse
{
    private ?string $message = null;
    private mixed $array = [];
    private int $status = 200;
    private array $appends = [];

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param mixed $array
     */
    public function setArray(mixed $array): void
    {
        $this->array = $array;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param mixed $appends
     */
    public function setAppends(mixed $appends): void
    {
        $this->appends = $appends;
    }


    public function response()
    {
        $data = [];
        if (!is_null($this->array) && !empty($this->array)) {
            if (is_null($this->message) && empty($this->message) && empty($this->appends)) {
                $data = $this->array;
            } else {
                $data['data'] = $this->array;
            }
        }
        !is_null($this->message) && $data['message'] = $this->message;
        !is_null($this->appends) && $data = array_merge($data, $this->appends);
        return response()->json($data, $this->status);
    }
}
