<?php

namespace Dzorogh\Family\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum ContactType: string implements HasLabel
{
    case Facebook = 'facebook';
    case Linkedin  = 'linkedin';
    case Wikipedia = 'wikipedia';
    case VK = 'vk';
    case Email = 'email';
    case Phone = 'phone';
    case Telegram = 'telegram';
    case Whatsapp = 'whatsapp';
    case Viber = 'viber';
    case Website = 'website';
    case Archive = 'archive';

    public function getLabel(): ?string
    {
        return $this->name;

        // or

//        return match ($this) {
//            self::Facebook => 'Facebook',
//            self::Linkedin => 'Linkedin',
//            self::Wikipedia => 'Wikipedia',
//            self::VK => 'VK',
//            self::Email => 'Email',
//            self::Phone => 'Phone',
//            self::Telegram => 'Telegram',
//            self::Whatsapp => 'Whatsapp',
//            self::Viber => 'Viber',
//            self::Website => 'Website',
//            self::Archive => 'Archive',
//        };
    }
}
