<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Log;

class AuthController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function register(Request $request)
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

            DB::commit();

            return responder()->success($user);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }
}
