<?php

namespace App\Http\Controllers;

use App\models\Virtualtourgallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Log;

class VirtualtourgalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Virtualtourgallery::all();
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
        $virtualtourgallery = new Virtualtourgallery;
        $virtualtourgallery->name = $request->input('name');
        $virtualtourgallery->virtualtour_id = $request->get('virtualtour_id');
        if ($request->hasfile('gallery')) {
            $file = $request->file('gallery');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/virtualtourgallery/', $filename);
            $virtualtourgallery->gallery = $filename;
        }
        try {
            $virtualtourgallery->save();

            return 'Gallery image Added Successfully';
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $Virtualtourgallery = Virtualtourgallery::find($id);
        $Virtualtourgallery->name = $request->input('name');
        $Virtualtourgallery->virtualtour_id = $request->input('virtualtour_id');

        if ($request->hasfile('gallery')) {
            $destination = 'uploads/Virtualtourgallery/'.$Virtualtourgallery->gallery;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('gallery');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/Virtualtourgallery/', $filename);
            $Virtualtourgallery->gallery = $filename;
        }
        try {
            $Virtualtourgallery->update();

            return 'Gallery image Updated Successfully';
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
    public function delete($id)
    {
        $virtualtourgallery = Virtualtourgallery::find($id);
        $destination = 'uploads/virut$virtualtourgallery/'.$virtualtourgallery->gallery;
        if (File::exists($destination)) {
            File::delete($destination);
        }
        $virtualtourgallery->delete();

        return 'Gallery image Deleted Successfully';
    }
}
