@extends('layouts.app')

@section('title', 'Lupa Kata Laluan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo_ePKAH.png') }}" alt="Logo ePKAH" class="logo mb-3">
                <h2>Lupa Kata Laluan</h2>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('forgot-password.post') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="telefon" class="form-label">No Telefon</label>
                            <input type="text" 
                                   class="form-control @error('telefon') is-invalid @enderror" 
                                   id="telefon" 
                                   name="telefon" 
                                   value="{{ old('telefon') }}" 
                                   placeholder="Masukkan no telefon anda" 
                                   required>
                            @error('telefon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Hantar Kata Laluan Baru</button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}">Kembali ke Log Masuk</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 