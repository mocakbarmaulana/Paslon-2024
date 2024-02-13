<?php

namespace App\Enum;

use Spatie\Enum\Enum;

/**
 * @method static self PRESIDEN()
 * @method static self WAKIL_PRESIDEN()
 */
class PosisiEnum extends Enum
{
    const PRESIDEN = 'Presiden';

    const WAKIL_PRESIDEN = 'Wakil Presiden';
}
