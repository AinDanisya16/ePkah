<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SekolahController extends Controller
{
    /**
     * Show sekolah dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        return view('sekolah.dashboard', compact('user'));
    }

    /**
     * Show sekolah penghantaran
     */
    public function penghantaran()
    {
        $user = Auth::user();
        
        return view('sekolah.penghantaran', compact('user'));
    }

    /**
     * Show first page
     */
    public function firstPage()
    {
        return view('sekolah.first-page');
    }
} 