<?php

namespace App\Enums;

enum CustomerSource: string
{
   case FACEBOOK = 'facebook';
   case INSTAGRAM = 'instagram';
   case WHATSAPP = 'whatsapp';
   case OTHER = 'other';
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
