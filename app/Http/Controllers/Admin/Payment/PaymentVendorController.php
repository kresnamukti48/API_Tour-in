<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymentVendor;
use Illuminate\Http\Request;
use Log;

class PaymentVendorController extends Controller
{
    protected $vendor;

    public function __construct()
    {
        $this->vendor = new PaymentVendor();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $vendor = $this->vendor->query();

            $search = $request->search;
            if (! empty($search)) {
                $vendor = $vendor->search($search);
            }

            $vendor = $vendor->paginate(10);

            return responder()->success([
                'data' => $vendor,
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
            'name' => 'required',
        ]);
        try {
            $paymentVendor = $this->vendor->create($request->all());

            return responder()->success([
                'message' => 'Berhasil menambah data payment vendor',
                'data' => $paymentVendor,
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
     * @param  \App\Models\PaymentVendor  $paymentVendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentVendor $paymentVendor)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            $paymentVendor->update($request->except(['_method']));

            return responder()->success([
                'message' => 'Berhasil mengubah data payment vendor',
                'data' => $paymentVendor,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentCategory  $paymentCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentVendor $paymentVendor)
    {
        try {
            $paymentVendor->delete();

            return responder()->success([
                'message' => 'Data berhasil di hapus',
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
            $vendor = $this->vendor->query();

            $vendor = $vendor->onlyTrashed();

            $search = $request->search;
            if (! empty($search)) {
                $vendor = $vendor->search($search);
            }

            $vendor = $vendor->paginate(10);

            return responder()->success([
                'data' => $vendor,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Restore trashed resource.
     *
     * @param  \App\Models\PaymentVendor  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $paymentVendor = $this->vendor->onlyTrashed()->findOrFail($id);
        try {
            $paymentVendor->restore();

            return responder()->success([
                'message' => 'Berhasil mengembalikan data payment vendor',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
