<?php

namespace Dzorogh\Family\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum DatePrecision: string implements HasLabel
{
    case Exact = 'exact';
    case Approximate  = 'approximate';
    case Year = 'year';
    case Decade = 'decade';
    case Century = 'century';


    public function getLabel(): ?string
    {
        return Str::headline($this->name);

        // or

//        return match ($this) {
//            self::Exact => 'Draft',
//            self::Year => 'Reviewing',
//            self::Decade => 'Published',
//            self::Century => 'Rejected',
//        };
    }
}
