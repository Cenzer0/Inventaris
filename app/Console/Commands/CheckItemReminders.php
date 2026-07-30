<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use App\Models\User;
use App\Notifications\ItemReminderNotification;
use App\Notifications\VehicleTaxReminderNotification;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;

class CheckItemReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-item-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Periksa pengingat untuk pemeliharaan elektronik dan mebeler (1 tahun), servis kendaraan (3 bulan), dan pajak kendaraan (tahunan)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admins = User::whereIn('role', ['admin_gudang', 'superadmin', 'pimpinan'])->get();

        if ($admins->isEmpty()) {
            $this->warn('Tidak ada user admin/pimpinan untuk menerima notifikasi.');
            return;
        }

        $this->checkMaintenance($admins);
        $this->checkVehicleService($admins);
        $this->checkVehicleTax($admins);

        $this->info('Pemeriksaan pengingat selesai.');
    }

    /**
     * 1. Elektronik & Mebeler — Pengingat Pemeliharaan Setiap 1 Tahun
     * Mengirim notifikasi jika purchase_date sudah lewat 1 tahun.
     */
    private function checkMaintenance($admins)
    {
        $oneYearAgo = Carbon::now()->subYear();

        $items = Item::whereIn('item_type', ['Elektronik', 'Mebeler'])
            ->whereNotNull('purchase_date')
            ->whereDate('purchase_date', '<', $oneYearAgo)
            ->get();

        foreach ($items as $item) {
            // Cek apakah notifikasi sudah dikirim dalam 30 hari terakhir
            $alreadySent = DatabaseNotification::where('type', ItemReminderNotification::class)
                ->where('data->item_id', $item->id)
                ->where('data->message', 'like', '%Pemeliharaan rutin tahunan%')
                ->where('created_at', '>=', Carbon::now()->subDays(30))
                ->exists();

            if (!$alreadySent) {
                $age = Carbon::parse($item->purchase_date)->diffInYears(Carbon::now());
                $reason = "Pemeliharaan rutin tahunan sudah jatuh tempo. Barang sudah berusia {$age} tahun (dibeli: " . Carbon::parse($item->purchase_date)->format('d/m/Y') . '). Segera lakukan pemeliharaan.';
                Notification::send($admins, new ItemReminderNotification($item, $reason));
                $this->info("✓ Notifikasi pemeliharaan {$item->item_type}: {$item->name}");
            }
        }

        $this->info("  Elektronik & Mebeler diperiksa: {$items->count()} item ditemukan.");
    }

    /**
     * 2. Kendaraan — Pengingat Servis Setiap 3 Bulan
     * Mengirim notifikasi jika last_service_date sudah lewat 3 bulan.
     */
    private function checkVehicleService($admins)
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        $vehicles = Item::where('item_type', 'Kendaraan')
            ->whereNotNull('last_service_date')
            ->whereDate('last_service_date', '<=', $threeMonthsAgo)
            ->get();

        foreach ($vehicles as $item) {
            // Cek apakah notifikasi sudah dikirim dalam 30 hari terakhir
            $alreadySent = DatabaseNotification::where('type', ItemReminderNotification::class)
                ->where('data->item_id', $item->id)
                ->where('data->message', 'like', '%servis rutin%')
                ->where('created_at', '>=', Carbon::now()->subDays(30))
                ->exists();

            if (!$alreadySent) {
                $daysSince = Carbon::parse($item->last_service_date)->diffInDays(Carbon::now());
                $reason = "Waktunya servis rutin! Sudah {$daysSince} hari sejak servis terakhir (" . Carbon::parse($item->last_service_date)->format('d/m/Y') . '). Segera jadwalkan servis.';
                Notification::send($admins, new ItemReminderNotification($item, $reason));
                $this->info("✓ Notifikasi servis Kendaraan: {$item->name}");
            }
        }

        $this->info("  Kendaraan (servis) diperiksa: {$vehicles->count()} item ditemukan.");
    }

    /**
     * 3. Kendaraan — Pengingat Pajak Tahunan
     * Mengirim notifikasi 30 hari sebelum bulan pajak dan selama bulan pajak berlangsung.
     */
    private function checkVehicleTax($admins)
    {
        $now = Carbon::now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        $vehicles = Item::where('item_type', 'Kendaraan')
            ->whereNotNull('tax_month')
            ->get();

        $sentCount = 0;

        foreach ($vehicles as $item) {
            $taxMonth = (int) $item->tax_month;
            $taxMonthName = Item::MONTH_NAMES[$taxMonth] ?? 'Bulan ' . $taxMonth;

            // Hitung tanggal awal bulan pajak dan 30 hari sebelumnya
            $taxDate = Carbon::create($currentYear, $taxMonth, 1);
            $reminderStart = $taxDate->copy()->subDays(30);
            $taxMonthEnd = $taxDate->copy()->endOfMonth();

            // Kirim notifikasi jika sekarang dalam rentang: 30 hari sebelum s/d akhir bulan pajak
            $shouldNotify = $now->between($reminderStart, $taxMonthEnd);

            // Juga cek untuk kasus tahun berikutnya (misal: tax_month = 1, sekarang Desember)
            if (!$shouldNotify) {
                $taxDateNextYear = Carbon::create($currentYear + 1, $taxMonth, 1);
                $reminderStartNext = $taxDateNextYear->copy()->subDays(30);
                $taxMonthEndNext = $taxDateNextYear->copy()->endOfMonth();
                $shouldNotify = $now->between($reminderStartNext, $taxMonthEndNext);
            }

            if ($shouldNotify) {
                // Cek duplikasi: tidak kirim ulang jika sudah ada notifikasi pajak dalam 30 hari terakhir
                $alreadySent = DatabaseNotification::where('type', VehicleTaxReminderNotification::class)
                    ->where('data->item_id', $item->id)
                    ->where('created_at', '>=', Carbon::now()->subDays(30))
                    ->exists();

                if (!$alreadySent) {
                    Notification::send($admins, new VehicleTaxReminderNotification($item, $taxMonthName));
                    $this->info("✓ Notifikasi pajak Kendaraan: {$item->name} (bulan {$taxMonthName})");
                    $sentCount++;
                }
            }
        }

        $this->info("  Kendaraan (pajak) diperiksa: {$vehicles->count()} item, {$sentCount} notifikasi dikirim.");
    }
}
