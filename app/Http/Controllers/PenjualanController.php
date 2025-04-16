<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Log;
use App\Models\Member;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

/**
 * Class PembelianController
 *
 * Controller untuk mengelola data pembelian, termasuk menampilkan, dan menambah pembelian.
 */
class PenjualanController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi penjualan.
     * 
     * @return \Illuminate\View\View
     */
    function index()
    {
        $penjualan = Penjualan::with(['detailPenjualan.buku', 'member', 'user'])->get();
        return view('penjualan.index', compact('penjualan'));
    }

    /**
     * Menampilkan form untuk membuat transaksi penjualan baru.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $stok = DB::table('view_buku_stok')->where('stok', '>', 0)->get();
        $member = Member::all();
        $voucher = Voucher::all();
        $buku = Buku::all();
        $kategori = Kategori::all();
        return view('penjualan.create', compact('member', 'buku', 'stok', 'kategori', 'voucher'));
    }

    /**
     * Menyimpan transaksi penjualan baru ke database lalu print
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(Request $request)
    {
        // Mengubah JSON buku menjadi array
        $bukuArray = json_decode($request->buku, true);
        if ($bukuArray === null) {
            return redirect()->back()->with('error', 'Data buku tidak valid!');
        }
        $request->merge(['buku' => $bukuArray]);

        // Validasi data input
        $request->validate([
            'total_bayar' => 'required|numeric|min:0',
            'total_bersih' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'member_id' => 'nullable|exists:member,id',
            'buku' => 'required|array',
            'buku.*.buku_id' => 'required|integer|exists:buku,id',
            'buku.*.harga_jual' => 'required|numeric|min:0',
            'buku.*.jumlah' => 'required|integer|min:1',
            'metode_bayar' => 'nullable|in:cash,qris',
            'bayar' => 'required|numeric|min:0',
            'kembali' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Membuat entri baru dalam tabel Penjualan
            $penjualan = Penjualan::create([
                'member_id' => $request->member_id,
                'user_id' => $request->user_id,
                'metode_bayar' => $request->metode_bayar,
                'total_bersih' => $request->total_bersih,
                'total_bayar' => $request->total_bayar,
                'diskon' => $request->diskon,
                'pajak' => $request->pajak,
            ]);

            if ($request->member_id) {
                $id = $request->member_id;
                $member = Member::findOrFail($id);
                $member->point - $request->minus_point;
            }

            foreach ($request->buku as $item) {
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'buku_id' => $item['buku_id'],
                    'harga_jual' => $item['harga_jual'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['harga_jual'] * $item['jumlah'],
                ]);
            }

            DB::commit();

            $bukuList = Buku::whereIn('id', array_column($request->buku, 'buku_id'))
                ->pluck('judul', 'id');

            $bukuSession = array_map(function ($item) use ($bukuList) {
                return [
                    'judul' => $bukuList[$item['buku_id']] ?? 'Buku',
                    'jumlah' => $item['jumlah'],
                    'harga_jual' => $item['harga_jual'],
                    'subtotal' => $item['harga_jual'] * $item['jumlah'],
                ];
            }, $request->buku);

            session([
                'no_transaksi' => $penjualan->no_transaksi,
                'total_bersih' => $request->total_bersih,
                'total_bayar' => $request->total_bayar,
                'diskon' => $request->diskon ?? 0,
                'bayar' => $request->bayar,
                'kembali' => $request->kembali,
                'buku' => $bukuSession,
                'created_at' => now()->format('d/m/Y H:i')
            ]);
            $printError = false;

            try {
                $penjualan->load('user', 'detailPenjualan.buku', 'member');
                $connector = new WindowsPrintConnector("POS-58");
                $printer = new Printer($connector);

                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("Toko Buku Astara\n");
                $printer->text("Jl. Bintang 444\n");
                $printer->text($penjualan->no_transaksi . "\n");
                $printer->text("--------------------------------\n");

                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $labelKasir = "Kasir:";
                $namaKasir = $penjualan->user->name ?? '-';
                $printer->text(str_pad($labelKasir, 16) . str_pad($namaKasir, 16, ' ', STR_PAD_LEFT) . "\n");
                $labelMember = "Member:";
                $namaMember = $penjualan->member->nama ?? '-';
                $printer->text(str_pad($labelMember, 16) . str_pad($namaMember, 16, ' ', STR_PAD_LEFT) . "\n");
                $printer->text("--------------------------------\n");

                foreach ($penjualan->detailPenjualan as $item) {
                    $judul = $item->buku->judul;
                    $printer->text($judul . "\n");

                    $qtyHarga = $item->jumlah . ' x ' . number_format($item->harga_jual, 0, ',', '.');
                    $subtotal = number_format($item->subtotal, 0, ',', '.');

                    $line = str_pad('  ' . $qtyHarga, 20) . str_pad($subtotal, 12, ' ', STR_PAD_LEFT);
                    $printer->text($line . "\n");
                }

                $printer->text("--------------------------------\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text("Subtotal  : Rp. " . number_format($request->total_bersih, 0, ',', '.') . "\n");
                $printer->text("Diskon    : Rp. " . number_format($request->diskon ?? 0, 0, ',', '.') . "\n");
                $printer->setEmphasis(true); // Mulai bold
                $printer->text("Total     : Rp. " . number_format($request->total_bayar, 0, ',', '.') . "\n");
                $printer->setEmphasis(false); // Balik ke normal
                $printer->text("Bayar     : Rp. " . number_format($request->bayar, 0, ',', '.') . "\n");
                $printer->text("Kembalian : Rp. " . number_format($request->kembali, 0, ',', '.') . "\n");

                $printer->feed(2);
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text($penjualan->created_at->format('d-m-Y H:i') . "\n");
                $printer->text("~ Terima kasih ~\n");
                $printer->barcode($penjualan->no_transaksi, Printer::BARCODE_CODE128); 
                $printer->qrCode("https://tokobuku-astara.test/qr-dummy", Printer::QR_ECLEVEL_L, 6);

                $printer->pulse();
                $printer->cut();
            } catch (\Exception $e) {
                $printError = true;
            } finally {
                if (isset($printer)) {
                    $printer->close();
                }
            }

            $message = $printError
                ? 'Transaksi berhasil, tapi struk gagal dicetak.'
                : 'Pembelian berhasil ditambahkan';

            return redirect()->back()->with('success', $message);
            // return redirect()->route('penjualan.create', ['print' => 'true'])->with([
            //     'success' => 'Transaksi berhasil ditambahkan!',
            //     'no_transaksi' => $penjualan->no_transaksi,
            //     'kembali' => $request->kembali,
            //     'diskon' => $request->diskon,
            //     'total_bersih' => $request->total_bersih,
            //     'total_bayar' => $request->total_bayar,
            //     'bayar' => $request->bayar,
            //     'buku' => $bukuArray,
            //     'created_at' => $penjualan->created_at->format('Y-m-d H:i:s')
            // ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Transaksi gagal! ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        // 
    }

    public function edit(string $id)
    {
        // 
    }

    public function update(Request $request, $id)
    {
        // 
    }

    public function destroy($id)
    {
        // 
    }
}
