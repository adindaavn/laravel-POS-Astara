<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Pemasok;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PembelianSeeder extends Seeder
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

            $pemasok = Pemasok::pluck('id');
            $books = Buku::all();

            for ($i = 0; $i < 10; $i++) {
                $pembelian = Pembelian::create([
                    'pemasok_id' => $pemasok->isNotEmpty() ? $pemasok->random() : null,
                    'user_id' => rand(1, 2),
                    'total' => 0, 
                    'tgl' => now()
                ]);

                // Generate random date within target month
                $randomDate = Carbon::createFromTimestamp(
                    rand($start->timestamp, $end->timestamp)
                )->format('Y-m-d H:i:s');

                // Update with actual random date
                DB::table('pembelian')
                    ->where('id', $pembelian->id)
                    ->update(['tgl' => $randomDate]);

                // Refresh model instance
                $pembelian->refresh();

                $total = 0;
                $details = [];

                foreach ($books->random(rand(1, 5)) as $buku) {
                    $jumlah = rand(10, 20);
                    $profit = 0;

                    if ($buku->harga < 50000) {
                        $profit = 20000;
                    } elseif ($buku->harga < 100000) {
                        $profit = 30000;
                    } elseif ($buku->harga < 150000) {
                        $profit = 40000;
                    } else {
                        $profit = 50000;
                    }

                    $harga = $buku->harga - $profit;

                    $details[] = [
                        'pembelian_id' => $pembelian->id, // Now properly linked
                        'buku_id' => $buku->id,
                        'harga_beli' => $harga,
                        'jumlah' => $jumlah,
                        'subtotal' => $harga * $jumlah
                    ];
                }

                $total = array_sum(array_column($details, 'subtotal'));

                $pembelian->update([
                    'total' => $total,
                ]);

                PembelianDetail::insert($details);
            }
        });
    }
}
