<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Console\Command;

class AssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign role to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $email = $this->ask('Masukkan email');
            $user = User::whereEmail($email)->first();
            if (empty($user)) {
                throw new Exception('User tidak ditemukan');
            }

            $this->table(
                ['ID', 'Role'],
                Role::orderBy('id')->get(['id', 'name'])->toArray()
            );
            $role_id = $this->ask('Pilih role');

            $role = Role::find($role_id);
            if (empty($role)) {
                throw new Exception('Role tidak ditemukan');
            }

            $user->assignRole($role);

            DB::commit();
            $this->info('Berhasil menambahkan role user');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->info('Gagal menambahkan role user: '.$th->getMessage());
        }
    }
}
