<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdatePembayaranMasaAktif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-pembayaran-masa-aktif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \App\Models\Pembayaran::where('is_bayar', 0)
            ->where('masa_aktif', '<', now())
            ->update(['is_bayar' => 1]);
    }



}