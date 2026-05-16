<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class InventoryApiController extends Controller
{
    
    public function index()
    {
        $inventories = Inventory::where('status', 'available')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'List data inventaris tersedia',
            'data' => $inventories
        ], 200);
    }

    
    public function checkIn(Request $request, $id)
    {
        
        $borrowing = Borrowing::where('inventory_id', $id)
                              ->where('status', 'approved')
                              ->first();

        
        if (!$borrowing) {
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman tidak ditemukan atau belum disetujui.'
            ], 404);
        }

       
        $borrowing->update([
            'status' => 'checked_in',
            'returned_at' => now() 
        ]);

        
        $borrowing->inventory->update(['status' => 'available']);

        
        return response()->json([
            'success' => true,
            'message' => 'Check-in peralatan berhasil direkam secara real-time.',
            'data' => $borrowing->load('inventory')
        ], 200);
    }
}
