<?php

namespace app\shared;

use Illuminate\Support\Arr;

class FilterCaseHandler
{
    public array $equalFields = [];
    public array $likeFields = [];
    public array $startLikeFields = [];
    public array $rangeFields = [];
    public array $inFields = [];
    public array $instrFields = [];

    public function filterFor($query, array $filters)
    {
        foreach ($this->equalFields as $field) {
            $query->when(Arr::exists($filters, $field), function ($q) use ($field, $filters) {
                $q->where($field, Arr::get($filters, $field));
            });
        }
        foreach ($this->startLikeFields as $field) {
            $query->when(Arr::exists($filters, $field), function ($q) use ($field, $filters) {
                $q->where($field, 'like', Arr::get($filters, $field).'%');
            });
        }
        foreach ($this->likeFields as $field) {
            $query->when(Arr::exists($filters, $field), function ($q) use ($field, $filters) {
                $q->where($field, 'like', '%'.Arr::get($filters, $field).'%');
            });
        }
        foreach ($this->rangeFields as $field) {
            $query->when(Arr::exists($filters, $field), function ($q) use ($field, $filters) {
                $rangeValues = Arr::get($filters, $field);
                if (! is_array($rangeValues)) {
                    $rangeValues = $this->csvStrToArr($rangeValues);
                }
                if (isset($rangeValues[0])) {
                    $q->where($field, '>=', $rangeValues[0]);
                }
                if (isset($rangeValues[1])) {
                    $q->where($field, '<=', $rangeValues[1]);
                }
            });
        }
        foreach ($this->inFields as $field) {
            $query->when(Arr::exists($filters, $field), function ($q) use ($field, $filters) {
                $rangeValues = Arr::get($filters, $field);
                if (! is_array($rangeValues)) {
                    $rangeValues = $this->csvStrToArr($rangeValues);
                }
                if (isset($rangeValues[0])) {
                    $q->whereIn($field, $rangeValues);
                }
            });
        }
        foreach ($this->instrFields as $field) {
            $query->when(Arr::exists($filters, $field), function ($q) use ($field, $filters) {
                $q->whereRaw('INSTR(?, '.$field.')>0', Arr::get($filters, $field));
            });
        }
        return $query;
    }

    private function csvStrToArr(string $csv, string $separator = ',') : array
    {
        $result = explode($separator, $csv);
        return array_map(trim(...), $result);
    }
}