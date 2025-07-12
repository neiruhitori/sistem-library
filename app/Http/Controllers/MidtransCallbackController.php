<?php

namespace App\Http\Controllers;

use App\Models\CatatanDenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    /**
     * Menerima notifikasi (webhook) dari server Midtrans.
     * URL ini harus diatur di Dashboard Midtrans > Settings > Payment Notification URL.
     * Untuk testing di localhost, gunakan Ngrok: `ngrok http 8000` dan atur URL-nya menjadi `https://[ngrok_url]/api/midtrans/callback`.
     */
    public function receive(Request $request)
    {
        $data = $request->all();

        Log::info('📩 Callback diterima dari Midtrans', ['body' => $data]);

        if (!$data || !isset($data['order_id'])) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        // Validasi Signature Key untuk keamanan
        $signatureKey = hash('sha512', $data['order_id'] . $data['status_code'] . $data['gross_amount'] . config('services.midtrans.server_key'));

        if ($data['signature_key'] !== $signatureKey) {
            Log::warning('❌ Invalid Signature Key.', ['request' => $data]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        Log::info('✅ Signature Key Valid.');

        $catatan = CatatanDenda::where('order_id', $data['order_id'])->first();

        if (!$catatan) {
            return response()->json(['message' => 'Order ID not found in database'], 404);
        }

        // PROSES berdasarkan status transaksi Midtrans
        switch ($data['transaction_status']) {
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
                Log::warning("❌ Pembayaran gagal atau dibatalkan untuk Catatan ID {$catatan->id}. Status: {$data['transaction_status']}");
                break;

            default:
                Log::warning("⚠️ Status tidak dikenali: {$data['transaction_status']}");
                break;
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
