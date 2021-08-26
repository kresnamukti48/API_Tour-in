<?php

namespace App\Http\Controllers\Seller;

use App\Exports\SouvenirExport;
use App\Http\Controllers\Controller;
use App\Mail\Export\SouvenirExportMail;
use App\Models\Souvenir;
use Auth;
use Illuminate\Http\Request;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class SouvenirController extends Controller
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
                'data' => Souvenir::where('user_id', Auth::id())->with(['store', 'souvenir_stock', 'user'])->paginate(10),
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
            'souvenir_name' => 'required',
            'souvenir_price' => 'required',
            'store_id' => 'required|exists:stores,id',
        ], [
            'store_id.exists' => 'Toko tidak valid',

        ]);

        $souvenir = new Souvenir();

        try {
            $souvenir->user_id = Auth::id();
            $souvenir->souvenir_name = $request->souvenir_name;
            $souvenir->souvenir_price = $request->souvenir_price;
            $souvenir->store_id = $request->store_id;
            $souvenir->save();

            return responder()->success([
                'message' => 'Data berhasil masuk!',
                'data' => $souvenir,
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
        $souvenir = Souvenir::findOrFail($id);
        $request->validate([
            'souvenir_name' => 'required',
            'souvenir_price' => 'required',
            'store_id' => 'required|exists:stores,id',
        ], [
            'store_id.exists' => 'Toko tidak valid',

        ]);

        try {
            $souvenir->souvenir_name = $request->souvenir_name;
            $souvenir->souvenir_price = $request->souvenir_price;
            $souvenir->store_id = $request->store_id;
            $souvenir->save();

            return responder()->success([
                'message' => 'Data berhasil di Update!',
                'data' => $souvenir,
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
        $souvenir = Souvenir::findOrFail($id);
        try {
            $souvenir->delete();

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
            $souvenir = Souvenir::all();
            $data = Excel::raw(new SouvenirExport($souvenir), \Maatwebsite\Excel\Excel::XLSX);

            Mail::to(Auth::user())->send(new SouvenirExportMail($data));

            return responder()->success([
                'message' => 'Hasil export data souvenir akan dikirimkan melalui email anda.',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
