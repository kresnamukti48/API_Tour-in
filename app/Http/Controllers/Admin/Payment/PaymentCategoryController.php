<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymentCategory;
use Illuminate\Http\Request;
use Log;

class PaymentCategoryController extends Controller
{
    protected $category;

    public function __construct()
    {
        $this->category = new PaymentCategory();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $category = $this->category->query();

            $search = $request->search;
            if (! empty($search)) {
                $category = $category->search($search);
            }

            $category = $category->paginate(10);

            return responder()->success([
                'data' => $category,
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
            $paymentCategory = $this->category->create($request->all());

            return responder()->success([
                'message' => 'Berhasil menambah data payment category',
                'data' => $paymentCategory,
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
     * @param  \App\Models\PaymentCategory  $paymentCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentCategory $paymentCategory)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            $paymentCategory->update($request->except(['_method']));

            return responder()->success([
                'message' => 'Berhasil mengubah data payment category',
                'data' => $paymentCategory,
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
    public function destroy(PaymentCategory $paymentCategory)
    {
        try {
            $paymentCategory->delete();

            return responder()->success([
                'message' => 'Berhasil menghapus data payment category',
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
            $category = $this->category->query();

            $category = $category->onlyTrashed();

            $search = $request->search;
            if (! empty($search)) {
                $category = $category->search($search);
            }

            $category = $category->paginate(10);

            return responder()->success([
                'data' => $category,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Restore trashed resource.
     *
     * @param  \App\Models\PaymentCategory  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $paymentCategory = $this->category->onlyTrashed()->findOrFail($id);
        try {
            $paymentCategory->restore();

            return responder()->success([
                'message' => 'Berhasil mengembalikan data payment category',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
