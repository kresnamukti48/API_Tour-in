<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Models\PaymentChannels;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Log;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = Ticket::query();
        try {
            $tour_id = $request->input('tour_id');
            if (! empty($tour_id)) {
                $table = $table->where('tour_id', $tour_id);
            }
            $table = $table->orderBy('id', 'DESC')->get();

            $table = $table->map(function ($ticket) {
                $channels = new Collection();
                foreach (PaymentChannels::with(['method'])->get() as $payment) {
                    $channels->push([
                        'channel_id' => $payment->id,
                        'channel_name' => $payment->payment_name,
                        'channel_status' => $payment->status(),
                        'channel_price' => $payment->method->getMarkupPrice($ticket->ticket_price),
                    ]);
                }
                $ticket['price'] = $channels;
                unset($ticket->ticket_price);

                return $ticket;
            });

            $table = CollectionHelper::paginate($table, 10);

            return responder()->success([
                'data' => $table,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
