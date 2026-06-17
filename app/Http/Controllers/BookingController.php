<?php

namespace App\Http\Controllers;

use App\Models\Casa;
use App\Models\Testimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // 1. Home / Landing Page (SUDAH DIPERBAIKI: RANDOM 3 ITEM)
    public function index()
    {
        // Mengambil 3 kos secara ACAK untuk rekomendasi
        $Casas = DB::table('casas')
                    ->inRandomOrder()
                    ->take(3)
                    ->get();
        $testimonios=Testimonio::all();
        $testimonios->casa_id;
        $casas=Casa::where('id',$testimonios)->get();
        return view('home', compact('casas'));
    }

    // 2. Detail Casa
    public function show($id)
    {
        $casa = DB::table('casas')->where('id', $id)->first();
        if (!$casa) abort(404);

        // Debugging (Opsional): Hapus // di bawah jika valoracion masih error
        // dd($casa);

        return view('casas.show', compact('casa'));
    }

    // 3. Form Booking
    public function create($id)
    {
        $casa = DB::table('casas')->where('id', $id)->first();
        return view('bookings.create', compact('casa'));
    }

    // 4. Proses Simpan Booking
    public function store(Request $request)
    {
        $request->validate([
            'casa_id' => 'required|exists:casas,id',
            'nombre_inquilino' => 'required|string|max:255',
            'num_movil' => 'required|string|max:20',
            'fecha_inicio' => 'required|date',
            'duracion' => 'required|integer|min:1',
        ]);

        $casa = DB::table('casas')->where('id', $request->casa_id)->first();
        $precio_total = $casa->precio * $request->duracion;

        $bookingId = DB::table('bookings')->insertGetId([
            'casa_id' => $request->casa_id,
            'nombre_inquilino' => $request->nombre_inquilino,
            'num_movil' => $request->num_movil,
            'fecha_inicio' => $request->fecha_inicio,
            'duracion' => $request->duracion,
            'precio_total' => $precio_total,
            'estado' => 'Pendiente',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('bookings.payment', $bookingId);
    }

    // 5. Halaman Pembayaran
    public function payment($id)
    {
        $booking = DB::table('bookings')
            ->join('casas', 'bookings.casa_id', '=', 'casas.id')
            ->select('bookings.*', 'casas.nombre_casa', 'casas.ubicacion')
            ->where('bookings.id', $id)
            ->first();

        if (!$booking) abort(404);

        return view('bookings.payment', compact('booking'));
    }

    // 6. Proses Upload Bukti Bayar
    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'comprobante_pago' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        if ($request->hasFile('comprobante_pago')) {
            $path = $request->file('comprobante_pago')->store('uploads', 'public');

            DB::table('bookings')->where('id', $id)->update([
                'comprobante_pago' => 'storage/' . $path,
                'estado' => 'Pagado',
                'updated_at' => now(),
            ]);

            return redirect()->route('bookings.success', $id);
        }

        return back()->withErrors(['comprobante_pago' => 'Gagal mengupload file. Silakan coba lagi.']);
    }

    // 7. Halaman Sukses
    public function success($id)
    {
        $booking = DB::table('bookings')
            ->join('casas', 'bookings.casa_id', '=', 'casas.id')
            ->select('bookings.*', 'casas.nombre_casa', 'casas.ubicacion')
            ->where('bookings.id', $id)
            ->first();

        if (!$booking) abort(404);

        return view('bookings.success', compact('booking'));
    }

    // 8. Riwayat Booking
    public function history()
    {
        $bookings = DB::table('bookings')
            ->join('casas', 'bookings.casa_id', '=', 'casas.id')
            ->select('bookings.*', 'casas.nombre_casa', 'casas.imagen_url')
            ->orderByDesc('bookings.created_at')
            ->get();

        return view('bookings.history', compact('bookings'));
    }

    // 9. Hapus Riwayat Booking
    public function destroy($id)
    {
        $booking = DB::table('bookings')->where('id', $id)->first();

        if ($booking) {
            // Hapus file bukti bayar dari penyimpanan jika ada
            if ($booking->comprobante_pago && file_exists(public_path($booking->comprobante_pago))) {
                unlink(public_path($booking->comprobante_pago));
            }

            // Hapus data dari database
            DB::table('bookings')->where('id', $id)->delete();

            return redirect()->route('bookings.history')->with('success', 'Riwayat booking berhasil dihapus.');
        }

        return back()->with('error', 'Data tidak ditemukan.');
    }

    // 10. Halaman Katalog / Cari Casa
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = DB::table('casas');

        if ($keyword) {
            $query->where('nombre_casa', 'like', "%{$keyword}%")
                  ->orWhere('ubicacion', 'like', "%{$keyword}%")
                  ->orWhere('direccion_completa', 'like', "%{$keyword}%");
        }

        $casas = $query->orderByDesc('created_at')->paginate(9);
        $casas->appends(['keyword' => $keyword]);

        return view('casas.index', compact('casas', 'keyword'));
    }
}
