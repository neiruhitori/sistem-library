<?php

namespace App\Http\Controllers;

use App\Models\CatatanDenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    // setiap ingin mengguanakan Midtrans, pastikan buka ngrok "ngrok http 8000"
    // dan linknya sesuaikan di Midtrans Payment Notification URL "https://BerubahUbahSetiapRunNgrok.app/api/midtrans/callback"
    // php artisan serve --host=127.0.0.1 --port=8000
    public function receive(Request $request)
    {
        $data = json_decode($request->getContent());

        Log::info('📩 Callback diterima dari Midtrans', ['body' => $data]);

        if (!$data || !isset($data->order_id)) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        $parts = explode('-', $data->order_id);
        $catatanId = $parts[1] ?? null;

        if (!$catatanId) {
            return response()->json(['message' => 'Invalid ID'], 400);
        }

        $catatan = CatatanDenda::find($catatanId);

        if (!$catatan) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // PROSES berdasarkan status transaksi Midtrans
        switch ($data->transaction_status) {
            case 'capture':
            case 'settlement':
                if ($catatan->status === 'belum_dibayar') {
                    $catatan->update([
                        'status' => 'dibayar',
                        'tanggal_bayar' => now(),
                    ]);
                    Log::info("✅ Catatan ID {$catatan->id} dibayar (settlement/capture)");
                }
                break;

            case 'pending':
                Log::info("⏳ Pembayaran pending untuk Catatan ID {$catatan->id}");
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                Log::warning("❌ Pembayaran gagal atau dibatalkan untuk Catatan ID {$catatan->id}. Status: {$data->transaction_status}");
                break;

            default:
                Log::warning("⚠️ Status tidak dikenali: {$data->transaction_status}");
                break;
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
