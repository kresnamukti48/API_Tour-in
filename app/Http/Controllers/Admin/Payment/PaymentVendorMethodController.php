<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymentCategory;
use App\Models\PaymentVendor;
use App\Models\PaymentVendorMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Log;

class PaymentVendorMethodController extends Controller
{
    protected $vendor;
    protected $category;
    protected $method;

    public function __construct()
    {
        $this->vendor = new PaymentVendor();
        $this->category = new PaymentCategory();
        $this->method = new PaymentVendorMethod();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $method = $this->method->query();

            $search = $request->search;
            if (! empty($search)) {
                $method = $method->search($search);
            }

            $method = $method->paginate(10);

            return responder()->success([
                'data' => $method,
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
            'payment_vendor_id' => 'required|exists:payment_vendors,id',
            'name' => 'required',
            'code' => 'required|unique:payment_vendor_methods,code',
            'type' => [
                'required',
                Rule::in([$this->method::TYPE_FIXED, $this->method::TYPE_PERCENTAGE]),
            ],
            'markup' => 'required|min:0|integer',
            'type_fee' => [
                'required',
                Rule::in([$this->method::TYPE_FEE_PG_FIXED, $this->method::TYPE_FEE_PG_PERCENTAGE]),
            ],
            'fee_pg' => 'required|min:0|integer',
            'type_disc' => [
                'required',
                Rule::in([$this->method::TYPE_DISC_PG_FIXED, $this->method::TYPE_DISC_PG_PERCENTAGE]),
            ],
            'disc_pg' => 'required|min:0|integer',
            'minimal_amount' => 'required|min:0|integer',
            'status' => [
                'required',
                Rule::in([$this->method::STATUS_DISABLED, $this->method::STATUS_ACTIVE]),
            ],
        ]);

        if ($request->filled('payment_category_id')) {
            $request->validate([
                'payment_category_id' => 'required|exists:payment_categories,id',
            ]);
        }

        try {
            $paymentVendorMethod = $this->method->create($request->all());

            return responder()->success([
                'message' => 'Berhasil menambah data payment method',
                'data' => $paymentVendorMethod,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentVendorMethod  $paymentVendorMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentVendorMethod $paymentVendorMethod)
    {
        $request->validate([
            'payment_vendor_id' => 'required|exists:payment_vendors,id',
            'name' => 'required',
            'code' => 'required', 'unique:payment_vendor_methods,code,'.$paymentVendorMethod->id,
            'type' => [
                'required',
                Rule::in([$this->method::TYPE_FIXED, $this->method::TYPE_PERCENTAGE]),
            ],
            'markup' => 'required|min:0|integer',
            'type_fee' => [
                'required',
                Rule::in([$this->method::TYPE_FEE_PG_FIXED, $this->method::TYPE_FEE_PG_PERCENTAGE]),
            ],
            'fee_pg' => 'required|min:0|integer',
            'type_disc' => [
                'required',
                Rule::in([$this->method::TYPE_DISC_PG_FIXED, $this->method::TYPE_DISC_PG_PERCENTAGE]),
            ],
            'disc_pg' => 'required|min:0|integer',
            'minimal_amount' => 'required|min:0|integer',
            'status' => [
                'required',
                Rule::in([$this->method::STATUS_DISABLED, $this->method::STATUS_ACTIVE]),
            ],
        ]);

        if ($request->filled('payment_category_id')) {
            $request->validate([
                'payment_category_id' => 'required|exists:payment_categories,id',
            ]);
        }
        try {
            $paymentVendorMethod->update($request->except(['_method']));

            return responder()->success([
                'message' => 'Berhasil mengubah data payment method',
                'data' => $paymentVendorMethod,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentVendorMethod  $paymentVendorMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentVendorMethod $paymentVendorMethod)
    {
        try {
            $paymentVendorMethod->delete();

            return responder()->success([
                'message' => 'Berhasil menghapus data payment method',
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
            $method = $this->method->query();

            $method = $method->onlyTrashed();

            $search = $request->search;
            if (! empty($search)) {
                $method = $method->search($search);
            }

            $method = $method->paginate(10);

            return responder()->success([
                'data' => $method,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Restore trashed resource.
     *
     * @param  \App\Models\PaymentVendorMethod  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $paymentVendorMethod = $this->method->onlyTrashed()->findOrFail($id);
        try {
            $paymentVendorMethod->restore();

            return responder()->success([
                'message' => 'Berhasil mengembalikan data payment method',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
