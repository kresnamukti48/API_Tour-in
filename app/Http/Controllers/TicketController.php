<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Log;

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
            $table = $table->orderBy('id', 'DESC')->paginate(10);

            return responder()->success($table);
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
}
