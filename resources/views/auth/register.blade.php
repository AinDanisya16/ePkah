@extends('layouts.app')

@section('title', 'Daftar Akaun')

@push('styles')
<style>
    .conditional-field {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo_ePKAH.png') }}" alt="Logo ePKAH" class="logo mb-3">
                <h2>Daftar Akaun e-PKAH</h2>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="peranan" class="form-label">Peranan</label>
                                    <select class="form-select @error('peranan') is-invalid @enderror" 
                                            id="peranan" 
                                            name="peranan" 
                                            required 
                                            onchange="toggleFields()">
                                        <option value="">--Pilih Peranan--</option>
                                        <option value="pengguna" {{ old('peranan') == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                                        <option value="sekolah/agensi" {{ old('peranan') == 'sekolah/agensi' ? 'selected' : '' }}>Sekolah/Agensi</option>
                                        <option value="vendor" {{ old('peranan') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                                        <option value="admin" {{ old('peranan') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('peranan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" 
                                           class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" 
                                           name="nama" 
                                           value="{{ old('nama') }}" 
                                           required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3 conditional-field" id="admin-field">
                                    <label for="id_kakitangan" class="form-label">No ID Kakitangan</label>
                                    <input type="text" 
                                           class="form-control @error('id_kakitangan') is-invalid @enderror" 
                                           id="id_kakitangan" 
                                           name="id_kakitangan" 
                                           value="{{ old('id_kakitangan') }}">
                                    @error('id_kakitangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="telefon" class="form-label">No Telefon</label>
                                    <input type="text" 
                                           class="form-control @error('telefon') is-invalid @enderror" 
                                           id="telefon" 
                                           name="telefon" 
                                           value="{{ old('telefon') }}" 
                                           required>
                                    @error('telefon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" 
                                           class="form-control @error('alamat') is-invalid @enderror" 
                                           id="alamat" 
                                           name="alamat" 
                                           value="{{ old('alamat') }}" 
                                           required>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="poskod" class="form-label">Poskod</label>
                                    <input type="text" 
                                           class="form-control @error('poskod') is-invalid @enderror" 
                                           id="poskod" 
                                           name="poskod" 
                                           value="{{ old('poskod') }}" 
                                           required>
                                    @error('poskod')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="jajahan" class="form-label">Jajahan/Daerah</label>
                                    <input type="text" 
                                           class="form-control @error('jajahan') is-invalid @enderror" 
                                           id="jajahan" 
                                           name="jajahan" 
                                           value="{{ old('jajahan') }}" 
                                           required>
                                    @error('jajahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="negeri" class="form-label">Negeri</label>
                                    <input type="text" 
                                           class="form-control @error('negeri') is-invalid @enderror" 
                                           id="negeri" 
                                           name="negeri" 
                                           value="{{ old('negeri') }}" 
                                           required>
                                    @error('negeri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">Katalaluan</label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Sahkan Katalaluan</label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Vendor specific fields -->
                        <div class="conditional-field" id="vendor-fields">
                            <h5 class="mt-4 mb-3">Maklumat Syarikat (Vendor)</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_syarikat" class="form-label">Nama Syarikat</label>
                                        <input type="text" 
                                               class="form-control @error('nama_syarikat') is-invalid @enderror" 
                                               id="nama_syarikat" 
                                               name="nama_syarikat" 
                                               value="{{ old('nama_syarikat') }}">
                                        @error('nama_syarikat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="no_syarikat" class="form-label">No Syarikat</label>
                                        <input type="text" 
                                               class="form-control @error('no_syarikat') is-invalid @enderror" 
                                               id="no_syarikat" 
                                               name="no_syarikat" 
                                               value="{{ old('no_syarikat') }}">
                                        @error('no_syarikat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Daftar Akaun</button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}">Sudah ada akaun? Log Masuk</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleFields() {
    const peranan = document.getElementById('peranan').value;
    const adminField = document.getElementById('admin-field');
    const vendorFields = document.getElementById('vendor-fields');
    
    // Hide all conditional fields first
    adminField.style.display = 'none';
    vendorFields.style.display = 'none';
    
    // Show relevant fields based on role
    if (peranan === 'admin') {
        adminField.style.display = 'block';
    } else if (peranan === 'vendor') {
        vendorFields.style.display = 'block';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleFields();
});
</script>
@endpush 