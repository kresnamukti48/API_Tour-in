<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Auth;
use Illuminate\Http\Request;
use Log;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|numeric',
            'review' => 'required',
            'rating' => 'required',
            'data_id' => 'required',
            'user_id' => 'required|exists:users,id',

        ], [
            'user_id.exists' => 'User tidak valid',
        ]);

        $review = new Review();

        try {
            $review->type = $request->type;
            $review->review = $request->review;
            if ($request->rating <= 0 || $request->rating > 5) {
                return responder()->error(null, 'Rating tidak sesuai format pilih.Silahkan masukkan 1-5');
            } else {
                $review->rating = $request->rating;
            }

            $review->data_id = $request->data_id;
            $review->user_id = $request->user_id;
            $review->save();

            return responder()->success([
                'message' => 'Data berhasil masuk!',
                'data' => $review,
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
    public function show(Request $request, $id)
    {
        $review = Review::Where([
            'type' => $request->type,
            'user_id' => Auth::id(),
            'data_id' => $request->data_id,
        ]);

        return responder()->success([
            'message' => 'Data Berhasil Ditampilkan!',
            'data' => $review,
        ]);
    }
}
