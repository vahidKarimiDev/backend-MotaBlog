<?php

namespace App\Base;

class ServiceResult
{
    public function __construct(public bool $ok, public mixed $data, public int $status = 200)
    {
    }
}
