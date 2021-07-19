<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Log;

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
                'data' => Store::all(),
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
            'user_id' => 'required|exists:users,id',
            'tour_id' => 'required|exists:tours,id',
        ], [
            'regency_id.exists' => 'Kota/Kabupaten tidak valid',
            'province_id.exist' => 'Provinsi tidak valid',
            'user_id.exist' => 'User tidak valid',
            'tour_id.exist' => 'Tempat Wisata tidak valid',

        ]);

        try {
            $store = Store::create($request->all());

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        try {
            $store->store_name = $request->store_name;
            $store->store_address = $request->store_address;
            $store->regency_id = $request->regency_id;
            $store->province_id = $request->province_id;
            $store->user_id = $request->user_id;
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
}
