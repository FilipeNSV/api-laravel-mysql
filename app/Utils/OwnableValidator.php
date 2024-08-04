<?php

namespace App\Utils;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Str;

class OwnableValidator
{
    /**
     * Checks if the ID is valid for the provided ownable type.
     *
     * @param  string  $ownableType
     * @param  int  $ownableId
     * @return string|bool
     */
    public static function validateOwnableTransaction(string $ownableType, int $ownableId): string|bool
    {
        $ownables = [
            'product' => Product::class,
            'service' => Service::class
        ];

        foreach ($ownables as $class) {
            if ($class === $ownableType) {
                return !is_null($class::find($ownableId)) ? $class : false;
            }
        }

        return false;
    }
}
