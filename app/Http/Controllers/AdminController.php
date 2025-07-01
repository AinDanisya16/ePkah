<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penghantaran;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalVendors = User::where('peranan', 'vendor')->count();
        $totalPengguna = User::where('peranan', 'pengguna')->count();
        $totalSekolah = User::where('peranan', 'sekolah/agensi')->count();
        
        $recentPenghantaran = Penghantaran::with('vendor')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalVendors', 
            'totalPengguna',
            'totalSekolah',
            'recentPenghantaran'
        ));
    }

    /**
     * Show admin first page
     */
    public function firstPage()
    {
        return view('admin.first-page');
    }

    /**
     * Show penghantaran list
     */
    public function penghantaran()
    {
        $penghantaran = Penghantaran::with('vendor')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.penghantaran', compact('penghantaran'));
    }

    /**
     * Show dalam proses penghantaran
     */
    public function dalamProses()
    {
        $penghantaran = Penghantaran::with('vendor')
            ->where('status_penghantaran', 'dalam_proses')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.dalam-proses', compact('penghantaran'));
    }

    /**
     * Show selesai penghantaran
     */
    public function selesai()
    {
        $penghantaran = Penghantaran::with('vendor')
            ->where('status_penghantaran', 'selesai')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.selesai', compact('penghantaran'));
    }

    /**
     * Show user list
     */
    public function senaraiPengguna()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.senarai-pengguna', compact('users'));
    }

    /**
     * Show vendor list
     */
    public function senaraiVendor()
    {
        $vendors = User::where('peranan', 'vendor')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.senarai-vendor', compact('vendors'));
    }

    /**
     * Show statistics
     */
    public function statistik()
    {
        $totalUsers = User::count();
        $totalVendors = User::where('peranan', 'vendor')->count();
        $totalPengguna = User::where('peranan', 'pengguna')->count();
        $totalSekolah = User::where('peranan', 'sekolah/agensi')->count();
        
        $totalPenghantaran = Penghantaran::count();
        $penghantaranDalamProses = Penghantaran::where('status_penghantaran', 'dalam_proses')->count();
        $penghantaranSelesai = Penghantaran::where('status_penghantaran', 'selesai')->count();

        return view('admin.statistik', compact(
            'totalUsers',
            'totalVendors',
            'totalPengguna', 
            'totalSekolah',
            'totalPenghantaran',
            'penghantaranDalamProses',
            'penghantaranSelesai'
        ));
    }

    /**
     * Update penghantaran status
     */
    public function updatePenghantaran(Request $request, Penghantaran $penghantaran)
    {
        $request->validate([
            'status_penghantaran' => 'required|in:dalam_proses,selesai'
        ]);

        $penghantaran->update([
            'status_penghantaran' => $request->status_penghantaran
        ]);

        return back()->with('success', 'Status penghantaran berjaya dikemaskini.');
    }

    /**
     * Delete penghantaran
     */
    public function deletePenghantaran(Penghantaran $penghantaran)
    {
        $penghantaran->delete();
        return back()->with('success', 'Penghantaran berjaya dipadam.');
    }
} 