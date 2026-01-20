<?php

namespace App\Console\Commands;

use App\Models\Agenda;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateAgendaStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agenda:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status agenda berdasarkan tanggal mulai dan selesai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        try {
            // Update agenda menjadi ongoing jika sudah dimulai dan belum selesai
            Agenda::where('date_start', '<=', $now)
                ->where(function ($query) use ($now) {
                    $query->whereNull('date_end')
                        ->orWhere('date_end', '>=', $now);
                })
                ->where('status', '!=', 'ongoing')
                ->update(['status' => 'ongoing']);

            // Update agenda menjadi done jika sudah lewat waktu selesai
            Agenda::whereNotNull('date_end')
                ->where('date_end', '<', $now)
                ->where('status', '!=', 'done')
                ->update(['status' => 'done']);

            // Update agenda yang belum dimulai menjadi upcoming
            Agenda::where('date_start', '>', $now)
                ->where('status', '!=', 'upcoming')
                ->update(['status' => 'upcoming']);

            $this->info('✓ Status agenda berhasil diperbarui!');
            Log::info('Agenda status updated successfully');

        } catch (\Exception $e) {
            $this->error('✗ Gagal memperbarui status agenda: ' . $e->getMessage());
            Log::error('Failed to update agenda status: ' . $e->getMessage());
        }
    }
}
