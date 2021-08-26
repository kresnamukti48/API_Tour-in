<?php

namespace App\Http\Controllers\Seller;

use App\Exports\StoreExport;
use App\Http\Controllers\Controller;
use App\Mail\Export\StoreExportMail;
use App\Models\Store;
use Auth;
use Illuminate\Http\Request;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class StoreController extends Controller
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
                'data' => Store::where('user_id', Auth::id())->with(['user', 'province', 'regency', 'tour'])->paginate(10),
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
            'store_name' => 'required',
            'store_address' => 'required',
            'regency_id' => 'required|exists:master_indonesia_cities,id',
            'province_id' => 'required|exists:master_indonesia_provinces,id',
            'tour_id' => 'required|exists:tours,id',
        ], [
            'regency_id.exists' => 'Kota/Kabupaten tidak valid',
            'province_id.exists' => 'Provinsi tidak valid',
            'tour_id.exists' => 'Tempat Wisata tidak valid',

        ]);

        $store = new Store();

        try {
            $store->user_id = Auth::id();
            $store->store_name = $request->store_name;
            $store->store_address = $request->store_address;
            $store->regency_id = $request->regency_id;
            $store->province_id = $request->province_id;
            $store->tour_id = $request->tour_id;
            $store->status = Store::STATUS_APPROVED;
            $store->save();

            return responder()->success([
                'message' => 'Data berhasil masuk!',
                'data' => $store,
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $request->validate([
            'store_name' => 'required',
            'store_address' => 'required',
            'regency_id' => 'required|exists:master_indonesia_cities,id',
            'province_id' => 'required|exists:master_indonesia_provinces,id',
            'tour_id' => 'required|exists:tours,id',
        ], [
            'regency_id.exists' => 'Kota/Kabupaten tidak valid',
            'province_id.exists' => 'Provinsi tidak valid',
            'tour_id.exists' => 'Tempat Wisata tidak valid',
            'status.numeric' => 'Status tidak valid',

        ]);

        try {
            $store->store_name = $request->store_name;
            $store->store_address = $request->store_address;
            $store->regency_id = $request->regency_id;
            $store->province_id = $request->province_id;
            $store->tour_id = $request->tour_id;
            $store->save();

            return responder()->success([
                'message' => 'Data berhasil di Update!',
                'data' => $store,
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
        $store = Store::findOrFail($id);
        try {
            $store->delete();

            return responder()->success([
                'message' => 'Data berhasil di Hapus',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    public function export(Request $request)
    {
        try {
            $store = Store::all();
            $data = Excel::raw(new StoreExport($store), \Maatwebsite\Excel\Excel::XLSX);

            Mail::to(Auth::user())->send(new StoreExportMail($data));

            return responder()->success([
                'message' => 'Hasil export data store akan dikirimkan melalui email anda.',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
