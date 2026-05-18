<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DeletePendingRegistrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pendaftaran:delete-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete pending registrations that are older than 3 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to delete pending registrations older than 3 days...');

        // Get pending registrations older than 3 days
        $threeDaysAgo = Carbon::now()->subDays(3);
        $pendingRegistrations = Pendaftaran::where('status', 'pending')
            ->where('created_at', '<', $threeDaysAgo)
            ->get();

        $count = $pendingRegistrations->count();

        if ($count > 0) {
            foreach ($pendingRegistrations as $pendaftaran) {
                // Delete associated files if any
                if ($pendaftaran->surat_keterangan_pkl) {
                    Storage::disk('public')->delete($pendaftaran->surat_keterangan_pkl);
                }
                if ($pendaftaran->surat_tanda_tangan) {
                    Storage::disk('public')->delete($pendaftaran->surat_tanda_tangan);
                }
                if ($pendaftaran->surat_mitra_signed) {
                    Storage::disk('public')->delete($pendaftaran->surat_mitra_signed);
                }
                if ($pendaftaran->surat_balasan_pkl) {
                    Storage::disk('public')->delete($pendaftaran->surat_balasan_pkl);
                }

                // Delete related surat uploads
                foreach ($pendaftaran->suratUploads as $suratUpload) {
                    Storage::disk('public')->delete($suratUpload->file_path);
                    $suratUpload->delete();
                }

                // Delete the registration
                $pendaftaran->delete();
            }

            $this->info("Successfully deleted {$count} pending registration(s) older than 3 days.");
        } else {
            $this->info('No pending registrations older than 3 days found.');
        }
    }
}
