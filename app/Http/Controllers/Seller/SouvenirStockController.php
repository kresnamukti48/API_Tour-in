<?php

namespace App\Http\Controllers\Seller;

use App\Exports\SouvenirStockExport;
use App\Http\Controllers\Controller;
use App\Imports\SouvenirStockImport;
use App\Mail\Export\SouvenirStockExportMail;
use App\Models\SouvenirStock;
use Auth;
use Illuminate\Http\Request;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

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
                'data' => SouvenirStock::where('user_id', Auth::id())->with(['souvenir', 'user'])->paginate(10),
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

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
            $stock->user_id = Auth::id();
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

    public function export(Request $request)
    {
        try {
            $souvenirstock = SouvenirStock::all();
            $data = Excel::raw(new SouvenirStockExport($souvenirstock), \Maatwebsite\Excel\Excel::XLSX);

            Mail::to(Auth::user())->send(new SouvenirStockExportMail($data));

            return responder()->success([
                'message' => 'Hasil export data souvenirstock akan dikirimkan melalui email anda.',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    public function Import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx',
        ]);

        try {
            $file = $request->file('file');
            $nama_file = rand().$file->getClientOriginalName();
            $file->move('file_stock', $nama_file);
            Excel::import(new SouvenirStockImport, public_path('/file_stock/'.$nama_file));

            return responder()->success([
                'message' => 'Data berhasil di Import!',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
