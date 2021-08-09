<?php

namespace App\Http\Controllers\TourManager;

use App\Http\Controllers\Controller;
use App\Models\Virtualtour;
use Auth;
use Illuminate\Http\Request;
use Log;

class VirtualTourController extends Controller
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
                'data' => Virtualtour::where('user_id', Auth::id())->with(['tour', 'virtual_tour_gallery'])->paginate(10),
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
            'tour_id' => 'required|exists:tours,id',
        ], [
            'tour_id.exists' => 'Tempat wisata tidak valid',
        ]);

        $virtualtour = new Virtualtour();

        try {
            $virtualtour->user_id = Auth::id();
            $virtualtour->tour_id = $request->tour_id;
            $virtualtour->save();

            return responder()->success([
                'message' => 'Data berhasil masuk!',
                'data' => $virtualtour,
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
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
        ], [
            'tour_id.exist' => 'Tempat wisata tidak valid',
        ]);

        $virtualtour = Virtualtour::findOrFail($id);

        try {
            $virtualtour->tour_id = $request->tour_id;
            $virtualtour->save();

            return responder()->success([
                'message' => 'Data berhasil di Update!',
                'data' => $virtualtour,
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
        $virtualtour = Virtualtour::findOrFail($id);

        try {
            $virtualtour->delete();

            return responder()->success([
                'message' => 'Data berhasil di Hapus',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}