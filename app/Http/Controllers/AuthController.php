<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Log;
use Str;

class AuthController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        return User::all();
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $user = $this->user->where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return responder()->error(null, 'The provided credentials are incorrect.');
            }

            $user['token'] = $user->createToken(Str::random(32))->plainTextToken;

            return responder()->success($user);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
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

    public function forgot(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? responder()->success(['status' => __($status)])
                : responder()->error(null, __($status));
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:9|confirmed',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? responder()->success(['status' => __($status)])
            : back()->withErrors(['email' => [__($status)]]);
    }
}
