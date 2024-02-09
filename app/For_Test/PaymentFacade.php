<?php

namespace App\For_Test;

use Illuminate\Support\Facades\Facade;

class PaymentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Payment::class;
    }


}
