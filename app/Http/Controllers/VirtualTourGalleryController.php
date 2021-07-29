<?php

namespace App\Http\Controllers;

use App\models\Virtualtourgallery;
use Illuminate\Http\Request;
use Log;
use Storage;

class VirtualTourGalleryController extends Controller
{
    protected $tempFile;

    public function __construct()
    {
        $this->tempFile = null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return responder()->success([
                'data' => Virtualtourgallery::with(['virtual_tour'])->get(),
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
            'name' => 'required',
            'gallery' => 'required|image',
            'virtualtour_id' => 'required|exists:virtualtours,id',
        ], [
            'virtualtour_id.exist' => 'Tempat wisata tidak valid',
        ]);

        try {
            $this->tempFile = $request->file('gallery')->store('virtualtourgallery', 'public');

            $virtualtourgallery = new Virtualtourgallery();
            $virtualtourgallery->name = $request->input('name');
            $virtualtourgallery->virtualtour_id = $request->get('virtualtour_id');
            $virtualtourgallery->gallery = $this->tempFile;
            $virtualtourgallery->save();

            return responder()->success([
                'message' => 'Gallery image Added Successfully',
                'data' => $virtualtourgallery,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());
            if ($this->tempFile != null) {
                Storage::disk('public')->delete($this->tempFile);
            }

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
            'name' => 'required',
            'gallery' => 'required|image',
            'virtualtour_id' => 'required|exists:virtualtours,id',
        ], [
            'virtualtour_id.exists' => 'Tempat wisata tidak valid',
        ]);

        $virtualtourgallery = Virtualtourgallery::findorFail($id);

        try {
            $virtualtourgallery->name = $request->name;
            $virtualtourgallery->virtualtour_id = $request->virtualtour_id;
            if ($request->hasfile('gallery')) {
                $oldImage = $virtualtourgallery->gallery;
                $this->tempFile = $request->file('gallery')->store('virtualtourgallery', 'public');
                $virtualtourgallery->gallery = $this->tempFile;
            }
            $virtualtourgallery->save();
            Storage::disk('public')->delete($oldImage);

            return responder()->success([
                'message' => 'Gallery image Updated Successfullyy',
                'data' => $virtualtourgallery,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());
            if ($this->tempFile != null) {
                Storage::disk('public')->delete($this->tempFile);
            }

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
        $virtualtourgallery = Virtualtourgallery::findOrFail($id);

        try {
            $gallery = $virtualtourgallery->gallery;
            $virtualtourgallery->delete();

            Storage::disk('public')->delete($gallery);

            return responder()->success([
                'message' => 'Gallery image Deleted Successfully',
                'gallery' => $virtualtourgallery,
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
