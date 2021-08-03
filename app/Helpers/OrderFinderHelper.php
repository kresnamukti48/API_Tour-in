<?php

use App\Models\OrderTicket;

if (! function_exists('order_finder')) {
    function order_finder($trxid, $merchantRef = null)
    {
        $order_ticket = OrderTicket::query();
        $order_ticket = $order_ticket->whereTrxId($trxid);
        if (! empty($merchantRef)) {
            $order_ticket = $order_ticket->whereMerchantRef($merchantRef);
        }
        if ($order_ticket->exists()) {
            return [
                'type' => 'ticket',
                'model' => OrderTicket::class,
                'data' => $order_ticket->first(),
            ];
        }

        throw new Exception('Data not found');
    }
}
