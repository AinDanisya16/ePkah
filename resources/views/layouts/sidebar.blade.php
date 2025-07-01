<nav class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo_ePKAH.png') }}" alt="Logo ePKAH" class="logo">
        <h3>e-PKAH</h3>
    </div>
    
    @auth
        <div class="user-info">
            <p>Selamat datang, {{ Auth::user()->nama }}</p>
            <small>{{ ucfirst(Auth::user()->peranan) }}</small>
        </div>
        
        <ul class="nav-links">
            @if(Auth::user()->isAdmin())
                <li><a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a></li>
                <li><a href="{{ route('admin.penghantaran') }}" class="nav-link">Penghantaran</a></li>
                <li><a href="{{ route('admin.dalam-proses') }}" class="nav-link">Dalam Proses</a></li>
                <li><a href="{{ route('admin.selesai') }}" class="nav-link">Selesai</a></li>
                <li><a href="{{ route('admin.senarai-pengguna') }}" class="nav-link">Senarai Pengguna</a></li>
                <li><a href="{{ route('admin.senarai-vendor') }}" class="nav-link">Senarai Vendor</a></li>
                <li><a href="{{ route('admin.statistik') }}" class="nav-link">Statistik</a></li>
            @elseif(Auth::user()->isVendor())
                <li><a href="{{ route('vendor.dashboard') }}" class="nav-link">Dashboard</a></li>
                <li><a href="{{ route('vendor.penghantaran') }}" class="nav-link">Penghantaran</a></li>
                <li><a href="{{ route('vendor.kutipan') }}" class="nav-link">Kutipan</a></li>
            @elseif(Auth::user()->isPengguna())
                <li><a href="{{ route('pengguna.dashboard') }}" class="nav-link">Dashboard</a></li>
                <li><a href="{{ route('pengguna.recycle-info') }}" class="nav-link">Info Kitar Semula</a></li>
                <li><a href="{{ route('pengguna.program') }}" class="nav-link">Program</a></li>
                <li><a href="{{ route('pengguna.lokasi') }}" class="nav-link">Lokasi</a></li>
            @elseif(Auth::user()->isSekolah())
                <li><a href="{{ route('sekolah.dashboard') }}" class="nav-link">Dashboard</a></li>
                <li><a href="{{ route('sekolah.penghantaran') }}" class="nav-link">Penghantaran</a></li>
            @endif
            
            <li class="divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link">Log Keluar</button>
                </form>
            </li>
        </ul>
    @else
        <ul class="nav-links">
            <li><a href="{{ route('login') }}" class="nav-link">Log Masuk</a></li>
            <li><a href="{{ route('register') }}" class="nav-link">Daftar Akaun</a></li>
        </ul>
    @endauth
</nav> 