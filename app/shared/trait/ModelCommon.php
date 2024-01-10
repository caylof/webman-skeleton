<?php

namespace app\shared\trait;

trait ModelCommon
{
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
