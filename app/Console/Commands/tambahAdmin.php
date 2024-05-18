<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class tambahAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tambah-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah membuatkan akun Admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $input['name'] = $this->ask('Masukan nama');
        $input['email'] = $this->ask('Masukan email');
        $input['is_admin'] = $this->ask('Apakah admin? (1/0)') ?? 1;
        $password = $this->secret('Masukan password') ?? '12345678'; // Gunakan default jika tidak ada input
        $input['password'] = Hash::make($password);

        User::create($input);
        $this->info('Admin telah ditambahkan! password default "12345678" beritahu untuk segera diganti!!');
    }
}
