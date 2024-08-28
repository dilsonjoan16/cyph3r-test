<?php
declare (strict_types = 1);

namespace App\Enums;

enum Currency: int
{
    case USD = 1;
    case VES = 2;
    case EUR = 3;
    case COP = 4;

    /**
     * Retrieves the symbol associated with the currency.
     *
     * @return string
     */
    public function symbol(): string
    {
        return match ($this) {
            self::USD => '$',
            self::VES => 'Bs',
            self::EUR => '€',
            self::COP => 'COL$',
        };
    }

    /**
     * Retrieves the iso3 associated with the currency.
     *
     * @return string
     */
    public function iso3(): string
    {
        return match ($this) {
            self::USD => 'USD',
            self::VES => 'VES',
            self::EUR => 'EUR',
            self::COP => 'COP',
        };
    }

    /**
     * Retrieves the id associated with the iso3.
     *
     * @return int
     */
    public static function currencyByIso3(string $iso3): int
    {
        return match ($iso3) {
            'USD' => self::USD->value,
            'VES' => self::VES->value,
            'EUR' => self::EUR->value,
            'COP' => self::COP->value,
        };
    }
}
