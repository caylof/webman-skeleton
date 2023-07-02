<?php

namespace app\shared\trait;

trait StaticCreateSelf
{
    public static function create(array $values): self
    {
        $me = new self();

        foreach ($values as $key => $value) {
            if (property_exists($me, $key)) {
                $me->$key = $value;
            }
        }

        return $me;
    }
}