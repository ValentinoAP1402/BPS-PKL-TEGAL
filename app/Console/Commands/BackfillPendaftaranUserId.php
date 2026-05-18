<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pendaftaran;
use App\Models\User;

class BackfillPendaftaranUserId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Tambahan opsi:
     * --dry-run : hanya tampilkan apa yang akan diubah (tidak save)
     * --limit=  : batasi jumlah data diproses (berguna saat data besar)
     *
     * @var string
     */
    protected $signature = 'app:backfill-pendaftaran-user-id {--dry-run} {--limit=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengisi pendaftarans.user_id berdasarkan pencocokan pendaftarans.email = users.email untuk data lama yang masih NULL.';

    public function handle()
    {
        $dryRun = (bool) $this->option('dry-run');
        $limit  = (int) ($this->option('limit') ?? 0);

        $query = Pendaftaran::query()
            ->whereNull('user_id')
            ->whereNotNull('email')
            ->where('email', '!=', '');

        if ($limit > 0) {
            $query->limit($limit);
        }

        $pendaftarans = $query->get();

        if ($pendaftarans->isEmpty()) {
            $this->info('Tidak ada data pendaftaran yang perlu di-backfill (user_id sudah terisi atau email kosong).');
            return Command::SUCCESS;
        }

        $this->info('Mulai backfill user_id untuk ' . $pendaftarans->count() . ' data pendaftaran...');
        if ($dryRun) {
            $this->warn('Mode DRY-RUN aktif: tidak ada perubahan yang akan disimpan ke database.');
        }

        $updated = 0;
        $skippedNoUser = 0;
        $skippedDuplicate = 0;

        $bar = $this->output->createProgressBar($pendaftarans->count());
        $bar->start();

        foreach ($pendaftarans as $p) {
            // Cari user berdasarkan email
            $user = User::where('email', $p->email)->first();

            if (!$user) {
                $skippedNoUser++;
                $bar->advance();
                continue;
            }

            // Jika ternyata sudah ada pendaftaran lain yang sudah pakai user_id ini
            // (penting jika kamu nanti bikin unique user_id)
            $alreadyUsed = Pendaftaran::where('user_id', $user->id)->exists();
            if ($alreadyUsed) {
                $skippedDuplicate++;
                $bar->advance();
                continue;
            }

            if (!$dryRun) {
                $p->user_id = $user->id;
                $p->save();
            }

            $updated++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Selesai.");
        $this->line("✅ Updated: {$updated}");
        $this->line("⚠️  Skipped (user tidak ditemukan dari email): {$skippedNoUser}");
        $this->line("⚠️  Skipped (user_id sudah dipakai pendaftaran lain): {$skippedDuplicate}");

        // Exit code sukses
        return Command::SUCCESS;
    }
}
