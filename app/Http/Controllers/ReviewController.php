<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Log;

class ReviewController extends Controller
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
                'data' => Review::with(['user'])->paginate(10),
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
        $review = Review::findOrFail($id);
        $request->validate([
            'type' => 'required|numeric',
            'review' => 'required',
            'rating' => 'required',
            'data_id' => 'required',
            'user_id' => 'required|exists:users,id',

        ], [

            'user_id.exists' => 'User tidak valid',
        ]);

        try {
            $review->type = $request->type;
            $review->review = $request->review;
            if ($request->rating <= 0 || $request->rating > 10) {
                return responder()->error(null, 'Rating tidak sesuai format pilih.Silahkan masukkan 1-10');
            } else {
                $review->rating = $request->rating;
            }

            $review->data_id = $request->data_id;
            $review->user_id = $request->user_id;
            $review->save();

            return responder()->success([
                'message' => 'Data berhasil di Update!',
                'data' => $review,
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
        $review = Review::findOrFail($id);

        try {
            $review->delete();

            return responder()->success([
                'message' => 'Data berhasil di Hapus',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
