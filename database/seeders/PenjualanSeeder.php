<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\StokBuku;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $targetMonth = now()->startOfMonth();
            $start = $targetMonth->copy()->startOfMonth();
            $end = $targetMonth->copy()->endOfMonth();

            $members = Member::pluck('id');
            $books = StokBuku::all();

            // Create 50 transactions
            for ($i = 0; $i < 60; $i++) {
                $penjualan = Penjualan::create([
                    'member_id' => $members->isNotEmpty() && rand(0, 1) ? $members->random() : null,
                    'user_id' => rand(1, 2),
                    'total_bayar' => 0, // Temporary placeholder
                    'total_bersih' => 0, // Temporary placeholder
                    'diskon' => 0,
                    'metode_bayar' => ['cash', 'qris'][rand(0, 1)],
                    'tgl' => now()
                ]);

                // Generate random date within target month
                $randomDate = Carbon::createFromTimestamp(
                    rand($start->timestamp, $end->timestamp)
                )->format('Y-m-d H:i:s');

                // Update with actual random date
                DB::table('penjualan')
                    ->where('id', $penjualan->id)
                    ->update(['tgl' => $randomDate]);

                // Refresh model instance
                $penjualan->refresh();

                $total_bersih = 0;
                $details = [];

                foreach ($books->random(rand(1, 5)) as $buku) {
                    if ($buku->stok > 0) {
                        $jumlah = rand(1, min(5, $buku->stok));

                        $details[] = [
                            'penjualan_id' => $penjualan->id,
                            'buku_id' => $buku->id,
                            'harga_jual' => $buku->harga,
                            'jumlah' => $jumlah,
                            'subtotal' => $buku->harga * $jumlah
                        ];
                    }
                }

                // Calculate totals
                $total_bersih = array_sum(array_column($details, 'subtotal'));
                $diskon = $total_bersih * (rand(0, 20) / 100);

                $penjualan->update([
                    'total_bayar' => $total_bersih - $diskon,
                    'total_bersih' => $total_bersih,
                    'diskon' => $diskon
                ]);

                PenjualanDetail::insert($details);
            }
        });
    }
}
