<?php

namespace App\Http\Controllers;

use App\Models\Tour;
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
                'data' => Tour::all(),
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
            'user_id' => 'required|exists:users,id',
        ], [
            'regency_id.exists' => 'Kota/Kabupaten tidak valid',
            'province_id.exists' => 'Provinsi tidak valid',
        ]);

        try {
            $tour = Tour::create($request->all());

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
            'user_id' => 'required|exists:users,id',
        ], [
            'regency_id.exists' => 'Kota/Kabupaten tidak valid',
            'province_id.exists' => 'Provinsi tidak valid',
        ]);

        try {
            $tour->tour_name = $request->tour_name;
            $tour->tour_address = $request->tour_address;
            $tour->regency_id = $request->regency_id;
            $tour->province_id = $request->province_id;
            $tour->user_id = $request->user_id;
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
