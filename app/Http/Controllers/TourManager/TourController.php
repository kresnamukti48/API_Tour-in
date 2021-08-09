<?php

namespace App\Http\Controllers\TourManager;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Auth;
use Illuminate\Http\Request;
use Log;

class TourController extends Controller
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
                'data' => Tour::where('user_id', Auth::id())->with(['user', 'province', 'regency', 'virtual_tour', 'store', 'ticket'])->paginate(10),
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
            'tour_name' => 'required',
            'tour_address' => 'required',
            'regency_id' => 'required|exists:master_indonesia_cities,id',
            'province_id' => 'required|exists:master_indonesia_provinces,id',
        ], [
            'regency_id.exists' => 'Kota/Kabupaten tidak valid',
            'province_id.exists' => 'Provinsi tidak valid',
        ]);

        $tour = new Tour();

        try {
            $tour->user_id = Auth::id();
            $tour->tour_name = $request->tour_name;
            $tour->tour_address = $request->tour_address;
            $tour->regency_id = $request->regency_id;
            $tour->province_id = $request->province_id;
            $tour->save();

            return responder()->success([
                'message' => 'Data berhasil masuk!',
                'data' => $tour,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function show(Tour $tour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);
        $request->validate([
            'tour_name' => 'required',
            'tour_address' => 'required',
            'regency_id' => 'required|exists:master_indonesia_cities,id',
            'province_id' => 'required|exists:master_indonesia_provinces,id',
        ], [
            'regency_id.exists' => 'Kota/Kabupaten tidak valid',
            'province_id.exists' => 'Provinsi tidak valid',
        ]);

        try {
            $tour->tour_name = $request->tour_name;
            $tour->tour_address = $request->tour_address;
            $tour->regency_id = $request->regency_id;
            $tour->province_id = $request->province_id;
            $tour->save();

            return responder()->success([
                'message' => 'Data berhasil di Update!',
                'data' => $tour,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);

        try {
            $tour->delete();

            return responder()->success([
                'message' => 'Data berhasil di Hapus',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
