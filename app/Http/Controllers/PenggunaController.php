<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    /**
     * Show pengguna dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        return view('pengguna.dashboard', compact('user'));
    }

    /**
     * Show pengguna penghantaran
     */
    public function penghantaran()
    {
        $user = Auth::user();
        
        return view('pengguna.penghantaran', compact('user'));
    }

    /**
     * Show recycle info
     */
    public function recycleInfo()
    {
        return view('pengguna.recycle-info');
    }

    /**
     * Show home page
     */
    public function home()
    {
        return view('pengguna.home');
    }

    /**
     * Show program info
     */
    public function program()
    {
        return view('pengguna.program');
    }

    /**
     * Show location info
     */
    public function lokasi()
    {
        return view('pengguna.lokasi');
    }

    /**
     * Show first page
     */
    public function firstPage()
    {
        return view('pengguna.first-page');
    }
} 