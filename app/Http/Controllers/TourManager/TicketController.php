<?php

namespace App\Http\Controllers\TourManager;

use App\Exports\TicketExport;
use App\Http\Controllers\Controller;
use App\Mail\Export\TicketExportMail;
use App\Models\Ticket;
use Auth;
use Illuminate\Http\Request;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = Ticket::query();
        try {
            $tour_id = $request->input('tour_id');
            if (! empty($tour_id)) {
                $table = $table->where('tour_id', $tour_id);
            }
            $table = $table->where('user_id', Auth::id())->with(['user', 'tour'])->orderBy('id', 'DESC')->paginate(10);

            return responder()->success($table);
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
            'ticket_name' => 'required',
            'ticket_price' => 'required',
            'detail' => 'required',
            'tour_id' => 'required|exists:tours,id',
        ], [
            'tour_id.exists' => 'Tempat Wisata tidak valid',

        ]);

        $ticket = new Ticket();

        try {
            $ticket->user_id = Auth::id();
            $ticket->ticket_name = $request->ticket_name;
            $ticket->ticket_price = $request->ticket_price;
            $ticket->detail = $request->detail;
            $ticket->tour_id = $request->tour_id;
            $ticket->save();

            return responder()->success([
                'message' => 'Data berhasil masuk!',
                'data' => $ticket,
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
        $ticket = Ticket::findOrFail($id);
        $request->validate([
            'ticket_name' => 'required',
            'ticket_price' => 'required',
            'detail' => 'required',
            'tour_id' => 'required|exists:tours,id',
        ], [
            'tour_id.exists' => 'Tempat Wisata tidak valid',

        ]);

        try {
            $ticket->ticket_name = $request->ticket_name;
            $ticket->ticket_price = $request->ticket_price;
            $ticket->detail = $request->detail;
            $ticket->tour_id = $request->tour_id;
            $ticket->save();

            return responder()->success([
                'message' => 'Data berhasil di Update!',
                'data' => $ticket,
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
        $ticket = Ticket::findOrFail($id);
        try {
            $ticket->delete();

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
            $tour = Ticket::all();
            $data = Excel::raw(new TicketExport($tour), \Maatwebsite\Excel\Excel::XLSX);

            Mail::to(Auth::user())->send(new TicketExportMail($data));

            return responder()->success([
                'message' => 'Hasil export data tour akan dikirimkan melalui email anda.',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
