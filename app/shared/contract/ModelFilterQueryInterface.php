<?php

namespace app\shared\contract;

use Illuminate\Database\Eloquent\Builder;

interface ModelFilterQueryInterface
{
    public static function buildFilterQuery(array $filters) : Builder;
}