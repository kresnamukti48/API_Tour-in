<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymentCategory;
use App\Models\PaymentChannels;
use App\Models\PaymentVendor;
use App\Models\PaymentVendorMethod;
use Illuminate\Http\Request;
use Log;
use Storage;

class PaymentChannelsController extends Controller
{
    protected $vendor;
    protected $category;
    protected $method;
    protected $channel;
    protected $tempLogo;

    public function __construct()
    {
        $this->vendor = new PaymentVendor();
        $this->category = new PaymentCategory();
        $this->method = new PaymentVendorMethod();
        $this->channel = new PaymentChannels();
        $this->tempLogo = null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $channel = $this->channel->query();

            $search = $request->search;
            if (! empty($search)) {
                $channel = $channel->search($search);
            }

            $channel = $channel->paginate(10);

            return responder()->success([
                'data' => $channel,
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
            'payment_method_vendor_id' => 'required|exists:payment_vendor_methods,id|unique:payment_channels,payment_method_vendor_id',
            'payment_name' => 'required',
            'payment_code' => 'required',
            'payment_logo' => 'required|image|max:5000',
            'payment_description' => 'required',
            'status' => 'required|numeric',
        ]);

        try {
            $this->tempLogo = $request->file('payment_logo')->store('payment_logo', 'public');
            $paymentChannels = $this->channel->create([
                'payment_method_vendor_id' => $request->payment_method_vendor_id,
                'payment_name' => $request->payment_name,
                'payment_code' => $request->payment_code,
                'payment_logo' => $this->tempLogo,
                'payment_description' => $request->payment_description,
                'status' => $request->status,
            ]);

            return responder()->success([
                'message' => 'Berhasil menambah data payment channel',
                'data' => $paymentChannels,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());
            if (! empty($this->tempLogo)) {
                Storage::disk('public')->delete($this->tempLogo);
            }

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentChannels  $paymentChannels
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentChannels $paymentChannels)
    {
        $request->validate([
            'payment_method_vendor_id' => 'required|exists:payment_vendor_methods,id|unique:payment_channels,payment_method_vendor_id,'.$paymentChannels->id,
            'payment_name' => 'required',
            'payment_code' => 'required',
            'payment_logo' => 'required|image|max:5000',
            'payment_description' => 'required',
            'status' => 'required|numeric',
        ]);

        try {
            $this->tempLogo = $request->file('payment_logo')->store('payment_logo', 'public');
            $oldLogo = $paymentChannels->payment_logo;
            $update = $paymentChannels->update([
                'payment_method_vendor_id' => $request->payment_method_vendor_id,
                'payment_name' => $request->payment_name,
                'payment_code' => $request->payment_code,
                'payment_logo' => $this->tempLogo,
                'payment_description' => $request->payment_description,
                'status' => $request->status,
            ]);
            if ($update) {
                Storage::disk('public')->delete($oldLogo);
            }

            return responder()->success([
                'message' => 'Berhasil mengubah data payment channel',
                'data' => $paymentChannels,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());
            if (! empty($this->tempLogo)) {
                Storage::disk('public')->delete($this->tempLogo);
            }

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentChannels  $paymentChannels
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentChannels $paymentChannels)
    {
        try {
            $paymentChannels->delete();

            return responder()->success([
                'message' => 'Berhasil menghapus data payment channel',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Display a listing of trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        try {
            $channel = $this->channel->query();

            $channel = $channel->onlyTrashed();

            $search = $request->search;
            if (! empty($search)) {
                $channel = $channel->search($search);
            }

            $channel = $channel->paginate(10);

            return responder()->success([
                'data' => $channel,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Restore trashed resource.
     *
     * @param  \App\Models\PaymentChannels  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $paymentChannels = $this->channel->onlyTrashed()->findOrFail($id);
        try {
            $paymentChannels->restore();

            return responder()->success([
                'message' => 'Berhasil mengembalikan data payment channel',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
