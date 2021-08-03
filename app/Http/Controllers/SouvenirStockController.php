<?php

namespace App\Http\Controllers;

use App\Models\SouvenirStock;
use Illuminate\Http\Request;
use Log;

class SouvenirStockController extends Controller
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
                'data' => SouvenirStock::with(['souvenir'])->paginate(10),
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
            'date' => 'required|date',
            'qty_in' => 'required',
            'qty_out' => 'required',
            'souvenir_id' => 'required|exists:souvenirs,id',
        ], [
            'date.date' => 'Format Tanggal tidak sesuai',
            'souvenir_id.exists' => 'Souvenir tidak valid',

        ]);

        $stock = new SouvenirStock();

        try {
            $stock->date = $request->date;
            $stock->qty_in = $request->qty_in;
            $stock->qty_out = $request->qty_out;
            $stock->note = $request->note;
            $stock->souvenir_id = $request->souvenir_id;
            $stock->save();

            return responder()->success([
                'message' => 'Data berhasil masuk!',
                'data' => $stock,
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
        $stock = SouvenirStock::findOrFail($id);
        $request->validate([
            'date' => 'required|date',
            'qty_in' => 'required',
            'qty_out' => 'required',
            'souvenir_id' => 'required|exists:souvenirs,id',
        ], [
            'date.date' => 'Format Tanggal tidak sesuai',
            'souvenir_id.exists' => 'Souvenir tidak valid',

        ]);

        try {
            $stock->date = $request->date;
            $stock->qty_in = $request->qty_in;
            $stock->qty_out = $request->qty_out;
            $stock->souvenir_id = $request->souvenir_id;
            $stock->save();

            return responder()->success([
                'message' => 'Data berhasil di Update!',
                'data' => $stock,
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
        $stock = SouvenirStock::findOrFail($id);
        try {
            $stock->delete();

            return responder()->success([
                'message' => 'Data berhasil di Hapus',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
