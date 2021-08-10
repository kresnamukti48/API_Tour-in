<?php

namespace App\Http\Controllers;

use App\Models\OrderSouvenir;
use App\Models\PaymentChannels;
use App\Models\Souvenir;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;

class OrderSouvenirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return responder()->success([
                'data' => OrderSouvenir::with(['user', 'souvenir', 'payment_channel'])->paginate(10),
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'souvenir_id' => 'required|exists:souvenirs,id',
            'payment_id' => 'required|exists:payment_channels,id',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email:rfc,strict,dns',
        ], [
            'souvenir_id.exists' => 'Souvenir tidak valid',
            'email.email' => 'Email tidak valid',
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $souvenir = Souvenir::findOrFail($request->souvenir_id);
            $disc_item = 0;

            $payment_channel = PaymentChannels::findOrFail($request->payment_id);

            $markup_pg = $payment_channel->method->getMarkupPrice($souvenir->souvenir_price - $disc_item) - ($souvenir->souvenir_price - $disc_item);
            $fee_pg = $payment_channel->method->getFeePaymentPrice($souvenir->souvenir_price - $disc_item);
            $disc_pg = $payment_channel->method->getDiscPaymentPrice($souvenir->souvenir_price - $disc_item);

            $order = new OrderSouvenir();
            $order->user_id = $user->id;
            $order->souvenir_id = $request->souvenir_id;
            $order->trx_id = genId();
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->souvenir_price = $souvenir->souvenir_price;
            $order->payment_id = $request->payment_id;
            $order->mark_up_fee = $markup_pg;
            $order->payment_fee = $fee_pg;
            $order->discount_item = $disc_item;
            $order->discount_payment = $disc_pg;
            $order->total = $souvenir->souvenir_price + $markup_pg - $disc_item;
            $order->save();

            $payment = createPayment('souvenir', $order->trx_id, frontRoute(route('status', $order->trx_id)));
            $order->payment_ref = $payment['redirect_url'];
            $order->merchant_ref = $payment['token'];
            $order->save();
            DB::commit();

            return responder()->success($order);
        } catch (\Throwable $th) {
            DB::rollback();
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = OrderSouvenir::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'souvenir_id' => 'required|exists:souvenirs,id',
            'trx_id' => 'required|unique:order_souvenirs,trx_id',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email:rfc,strict,dns',
            'souvenir_price' => 'required',
            'mark_up_fee' => 'required',
            'payment_fee' => 'required',
            'discount_item' => 'required',
            'discount_payment' => 'required',
            'payment_ref' => 'required',
            'merchant_ref' => 'required',
        ], [
            'user_id.exists' => 'User tidak valid',
            'souvenir_id.exists' => 'Souvenir tidak valid',
            'email.email' => 'Email tidak valid',
        ]);

        try {
            $order->user_id = $request->user_id;
            $order->souvenir_id = $request->souvenir_id;
            $order->trx_id = $request->trx_id;
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->souvenir_price = $request->souvenir_price;
            $order->mark_up_fee = $request->mark_up_fee;
            $order->payment_fee = $request->payment_fee;
            $order->discount_item = $request->discount_item;
            $order->discount_payment = $request->discount_payment;
            $order->total = $request->souvenir_price + $request->mark_up_fee - $request->discount_item;
            $order->payment_ref = $request->payment_ref;
            $order->merchant_ref = $request->merchant_ref;
            $order->save();

            return responder()->success([
                'message' => 'Data berhasil masuk!',
                'data' => $order,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = OrderSouvenir::findOrFail($id);
        try {
            $order->delete();

            return responder()->success([
                'message' => 'Data berhasil di Hapus',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
