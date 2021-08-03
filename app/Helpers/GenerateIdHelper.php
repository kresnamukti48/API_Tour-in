<?php

use App\Models\OrderTicket;

if (! function_exists('genId')) {
    function genId()
    {
        $number = (string) random_int(100000, 999999);

        if (checkId($number)) {
            return genId();
        }

        return $number;
    }
}

if (! function_exists('checkId')) {
    function checkId($number)
    {
        $exists = false;
        $ticket = OrderTicket::whereTrxId($number)->exists();
        if ($ticket) {
            $exists = true;
        }

        return $exists;
    }
}
