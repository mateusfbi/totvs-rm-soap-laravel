<?php

namespace mateusfbi\TotvsRmSoap\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;

class Record implements Arrayable
{
    public function __construct(
        public readonly array $data
    ) {}

    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
