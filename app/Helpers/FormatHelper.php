<?php

namespace CodeDelivery\Helpers;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;

/**
 * Class FormHelper
 * @package CodeDelivery\Helpers
 */
class FormatHelper
{
    public static function money($value, $symbol, $decimalSeparator, $thousandSeparator)
    {
        $formatted = '';
        if (is_numeric($value))
            $formatted = trim($symbol) . ' ' . number_format($value, 2, $decimalSeparator, $thousandSeparator);
            
        return $formatted;
    }

    public static function moneyBR($value)
    {
        return self::money($value, 'R$', ',', '.');
    }
}