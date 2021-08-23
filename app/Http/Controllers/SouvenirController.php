<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Models\PaymentChannels;
use App\Models\Souvenir;
use Illuminate\Support\Collection;
use Log;

class SouvenirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Souvenir::query();
            $data = $data->with(['store'])->get();

            $data = $data->map(function ($souvenir) {
                $channels = new Collection();
                foreach (PaymentChannels::with(['method'])->get() as $payment) {
                    $channels->push([
                        'channel_id' => $payment->id,
                        'channel_name' => $payment->payment_name,
                        'channel_status' => $payment->status(),
                        'channel_price' => $payment->method->getMarkupPrice($souvenir->souvenir_price),
                    ]);
                }
                $souvenir['price'] = $channels;
                $souvenir['souvenir_stock'] = $souvenir->souvenir_stock_ready();
                unset($souvenir->souvenir_price);

                return $souvenir;
            });

            $data = CollectionHelper::paginate($data, 10);

            return responder()->success([
                'data' => $data,
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
