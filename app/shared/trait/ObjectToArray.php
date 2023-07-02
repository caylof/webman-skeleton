<?php

namespace app\shared\trait;

trait ObjectToArray
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}