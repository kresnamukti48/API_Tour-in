<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->user = new User();
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
                'data' => User::all()->paginate(10),
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
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'email' => 'required|unique:users,email|email:rfc,strict,dns',
            'birthdate' => 'required|date',
            'gender' => 'required|numeric',
            'password' => 'required|confirmed',
        ], [
            'username.required' => 'Kolom username harus di isi',
            'username.unique' => 'Username sudah digunakan',
            'name.required' => 'Kolom nama harus di isi',
            'email.required' => 'Kolom email harus di isi',
            'email.unique' => 'Email sudah digunakan',
            'email.email' => 'Email tidak valid',
            'birthdate.required' => 'Tanggal lahir harus di isi',
            'birthdate.date' => 'Format tanggal lahir tidak sesuai',
            'gender.required' => 'Jenis kelamin harus di isi',
            'gender.numeric' => 'Jenis kelamin tidak valid',
            'password.required' => 'Kolom password harus di isi',
            'password.confirmed' => 'Password tidak sesuai',
        ]);

        DB::beginTransaction();
        try {
            $user = $this->user->create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
                'password' => bcrypt($request->password),
            ]);

            $user->syncRoles(Role::ROLE_USER);

            DB::commit();

            return responder()->success($user);
        } catch (\Throwable $th) {
            DB::rollback();
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
        $user = User::findOrFail($id);
        $request->validate([
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'email' => 'required|unique:users,email|email:rfc,strict,dns',
            'birthdate' => 'required|date',
            'gender' => 'required|numeric',
            'password' => 'required|confirmed',
        ], [
            'username.required' => 'Kolom username harus di isi',
            'username.unique' => 'Username sudah digunakan',
            'name.required' => 'Kolom nama harus di isi',
            'email.required' => 'Kolom email harus di isi',
            'email.unique' => 'Email sudah digunakan',
            'email.email' => 'Email tidak valid',
            'birthdate.required' => 'Tanggal lahir harus di isi',
            'birthdate.date' => 'Format tanggal lahir tidak sesuai',
            'gender.required' => 'Jenis kelamin harus di isi',
            'gender.numeric' => 'Jenis kelamin tidak valid',
            'password.required' => 'Kolom password harus di isi',
            'password.confirmed' => 'Password tidak sesuai',
        ]);

        try {
            $user->username = $request->username;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->birthdate = $request->birthdate;
            $user->gender = $request->gender;
            $user->password = $request->password;
            $user->save();

            return responder()->success([
                'message' => 'Data berhasil di Update!',
                'data' => $user,
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
        $user = User::findOrFail($id);
        try {
            $user->delete();

            return responder()->success([
                'message' => 'Data berhasil di Hapus',
            ]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
