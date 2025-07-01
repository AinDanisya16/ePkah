<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penghantaran;

class VendorController extends Controller
{
    /**
     * Show vendor dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $totalPenghantaran = Penghantaran::where('vendor_id', $user->id)->count();
        $penghantaranDalamProses = Penghantaran::where('vendor_id', $user->id)
            ->where('status_penghantaran', 'dalam_proses')
            ->count();
        $penghantaranSelesai = Penghantaran::where('vendor_id', $user->id)
            ->where('status_penghantaran', 'selesai')
            ->count();

        $recentPenghantaran = Penghantaran::where('vendor_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('vendor.dashboard', compact(
            'totalPenghantaran',
            'penghantaranDalamProses',
            'penghantaranSelesai',
            'recentPenghantaran'
        ));
    }

    /**
     * Show vendor first page
     */
    public function firstPage()
    {
        return view('vendor.first-page');
    }

    /**
     * Show vendor penghantaran
     */
    public function penghantaran()
    {
        $user = Auth::user();
        
        $penghantaran = Penghantaran::where('vendor_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('vendor.penghantaran', compact('penghantaran'));
    }

    /**
     * Show vendor kutipan
     */
    public function kutipan()
    {
        $user = Auth::user();
        
        // This would typically show collection data
        // For now, we'll show a basic view
        return view('vendor.kutipan');
    }

    /**
     * Update penghantaran status
     */
    public function updatePenghantaran(Request $request, Penghantaran $penghantaran)
    {
        // Ensure vendor can only update their own penghantaran
        if ($penghantaran->vendor_id !== Auth::id()) {
            abort(403, 'Akses tidak dibenarkan.');
        }

        $request->validate([
            'status_penghantaran' => 'required|in:dalam_proses,selesai'
        ]);

        $penghantaran->update([
            'status_penghantaran' => $request->status_penghantaran
        ]);

        return back()->with('success', 'Status penghantaran berjaya dikemaskini.');
    }
} 