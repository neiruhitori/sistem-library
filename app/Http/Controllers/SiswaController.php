<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\Siswa;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Writer\PngWriter;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        // Untuk DataTables, kirim semua data - pagination akan dihandle oleh DataTables
        if ($request->has('search')) {
            $siswa = Siswa::where('name', 'LIKE', '%' . $request->search . '%')
                ->orderBy('created_at', 'DESC')
                ->get(); // Ubah dari paginate(5) ke get()
        } else {
            $siswa = Siswa::orderBy('created_at', 'DESC')
                ->get(); // Ubah dari paginate(5) ke get()
        }
        return view('siswa.index', compact('siswa', 'profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $siswa = Siswa::all();
        return view('siswa.create', compact('siswa', 'profile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:50',
            'kelas' => 'required|min:1|max:50'
        ]);

        Siswa::create([
            'name' => $request->name,
            'kelas' => $request->kelas,
            'nisn' => $request->nisn,
        ]);
        return redirect('/siswa')->with('success', 'Data Berhasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $siswa = Siswa::findOrFail($id);
        return view('siswa.show', compact('siswa', 'profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa', 'profile'));
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('success', 'Siswa Berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->delete();

        return redirect()->back()->with('success', 'Siswa berhasil dihapus!');
    }

    public function exportPDF()
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $siswa = Siswa::all(); // atau paginate, terserah
        $pdf = PDF::loadView('siswa.pdf', compact('siswa'));
        return $pdf->stream('Daftar_Siswa_SMPN_02_Klakah.pdf', compact('profile'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data Siswa berhasil diimpor!');
    }
    public function hapussemua()
    {
        Siswa::query()->forceDelete();
        return redirect()->back()->with('removeAll', 'Hapus semua data Siswa successfully');
    }

    /**
     * Generate and print student ID card
     */
    public function printCard($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Generate QR Code menggunakan Endroid library
        $qrData = json_encode([
            // 'nama' => $siswa->name,
            // 'nisn' => $siswa->nisn,
            'id' => $siswa->id
        ]);

        $qr = new QrCode($qrData);
        $writer = new SvgWriter();
        $result = $writer->write($qr);

        $qrCode = base64_encode($result->getString());

        // Encode logo sebagai base64 untuk PDF
        $logoPath = public_path('AdminLTE-3.2.0/dist/img/smp2.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = base64_encode($logoData);
        }

        // Load view ke PDF dengan setting yang sama seperti file lama
        $pdf = PDF::loadView('siswa.card_fixed', compact('siswa', 'qrCode', 'logoBase64'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        return $pdf->stream('kartu-siswa-' . $siswa->name . '.pdf');
    }

    /**
     * Generate and export student ID card as PNG with 300 DPI
     */
    public function printCardPNG($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Generate QR Code menggunakan Endroid library untuk PNG
        $qrData = json_encode([
            'id' => $siswa->id
        ]);

        $qr = new QrCode($qrData);
        $writer = new PngWriter();
        $result = $writer->write($qr);
        $qrCode = base64_encode($result->getString());

        // Encode logo sebagai base64
        $logoPath = public_path('AdminLTE-3.2.0/dist/img/smp2.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = base64_encode($logoData);
        }

        // Create PNG template dengan DPI 300
        // Ukuran: 85.6mm x 53.98mm = 1012 x 640 pixels @ 300 DPI
        $width = 1012;
        $height = 640;

        // Load view untuk konversi ke PNG
        $html = view('siswa.card_png', compact('siswa', 'qrCode', 'logoBase64', 'width', 'height'))->render();

        // Convert HTML ke PDF dengan ukuran yang tepat untuk 300 DPI
        $pdf = PDF::loadHTML($html)
            ->setPaper([0, 0, $width * 0.75, $height * 0.75], 'portrait')
            ->setOptions([
                'dpi' => 300,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'enable_font_subsetting' => true
            ]);

        // Return PDF dengan resolusi tinggi untuk printing
        return $pdf->download('kartu-siswa-' . $siswa->name . '-300dpi.pdf');
    }
}
