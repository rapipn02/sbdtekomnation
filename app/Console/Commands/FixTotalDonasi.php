<?php

namespace App\Console\Commands;

use App\Models\DaftarDonasi;
use Illuminate\Console\Command;

class FixTotalDonasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donasi:fix-total';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix total donasi untuk semua daftar donasi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai perbaikan total donasi...');
        
        $daftarDonasis = DaftarDonasi::all();
        $bar = $this->output->createProgressBar($daftarDonasis->count());
        
        foreach ($daftarDonasis as $daftarDonasi) {
            $daftarDonasi->updateTotalDonasi();
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('Perbaikan total donasi selesai!');
        
        return Command::SUCCESS;
    }
}