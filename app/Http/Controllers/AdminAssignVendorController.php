<?php

namespace App\Http\Controllers;

use App\Models\Penghantaran;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAssignVendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function assignVendor(Request $request)
    {
        // Validate request
        $request->validate([
            'penghantaran_id' => 'required|integer|exists:penghantaran,id',
            'vendor_id' => 'required|integer|exists:vendors,id',
        ]);

        try {
            // Check if shipment exists
            $penghantaran = Penghantaran::findOrFail($request->penghantaran_id);

            // Update vendor assignment
            $penghantaran->update([
                'vendor_id' => $request->vendor_id,
                'status_penghantaran' => 'diproses'
            ]);

            return redirect()->route('admin.penghantaran')
                ->with('success', 'Vendor berjaya ditetapkan untuk penghantaran ini.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi ralat semasa menetapkan vendor!');
        }
    }

    public function showAssignForm($penghantaran_id)
    {
        $penghantaran = Penghantaran::findOrFail($penghantaran_id);
        $vendors = Vendor::all();

        return view('admin.assign-vendor', compact('penghantaran', 'vendors'));
    }
} 