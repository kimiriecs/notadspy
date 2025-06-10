<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Enum;

/**
 * Enum CurrencySymbol
 *
 * @package App\Enum
 */
enum CurrencySymbol: string
{
    case UAH = "\u{20B4}";
    case USD = "\u{0024}";
    case EUR = "\u{20AC}";

    /**
     * @return array
     */
    public static function foreign(): array
    {
        return [self::USD->value, self::EUR->value];
    }

    /**
     * @param string $name
     * @return CurrencySymbol|null
     */
    public static function tryFromName(string $name): ?CurrencySymbol
    {
        return array_find(self::cases(), fn(CurrencySymbol $symbol) => $symbol->name === $name);
    }
}
