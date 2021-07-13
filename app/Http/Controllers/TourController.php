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
        return Tour::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'province_id.exist' => 'Provinsi tidak valid',
        ]);

        try {
            Tour::create($request->all());

            return 'Data berhasil masuk!';
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function edit(Tour $tour)
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
        $tour_name = $request->tour_name;
        $tour_address = $request->tour_address;
        $regency_id = $request->regency_id;
        $province_id = $request->province_id;
        $user_id = $request->user_id;
        try {
            $tour = Tour::find($id);
            $tour->tour_name = $tour_name;
            $tour->tour_address = $tour_address;
            $tour->regency_id = $regency_id;
            $tour->province_id = $province_id;
            $tour->user_id = $user_id;
            $tour->save();

            return 'Data berhasil di Update!';
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
    public function delete($id)
    {
        $tour = Tour::find($id);
        $tour->delete();

        return 'Data berhasil di Hapus';
    }
}
