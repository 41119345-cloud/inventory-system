<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class InventoryApiController extends Controller
{
    // 1. Fungsi untuk mengirimkan daftar alat yang tersedia ke tablet (Format JSON)
    public function index()
    {
        $inventories = Inventory::where('status', 'available')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'List data inventaris tersedia',
            'data' => $inventories
        ], 200);
    }

    // 2. Fungsi menerima sinyal check-in alat dari tablet secara real-time
    public function checkIn(Request $request, $id)
    {
        // Cari catatan peminjaman alat yang statusnya disetujui (approved)
        $borrowing = Borrowing::where('inventory_id', $id)
                              ->where('status', 'approved')
                              ->first();

        // Jika data tidak ketemu, beri tahu tablet lewat error 404
        if (!$borrowing) {
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman tidak ditemukan atau belum disetujui.'
            ], 404);
        }

        // Jika ketemu, ubah status peminjaman menjadi 'checked_in' secara real-time
        $borrowing->update([
            'status' => 'checked_in',
            'returned_at' => now() // Catat waktu pengembalian saat ini juga
        ]);

        // Ubah juga status alatnya di lemari inventaris menjadi tersedia ('available') lagi
        $borrowing->inventory->update(['status' => 'available']);

        // Kirim balik respon sukses ke tablet
        return response()->json([
            'success' => true,
            'message' => 'Check-in peralatan berhasil direkam secara real-time.',
            'data' => $borrowing->load('inventory')
        ], 200);
    }
}
