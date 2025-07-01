@extends('layouts.app')

@section('title', 'Log Masuk')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo_ePKAH.png') }}" alt="Logo ePKAH" class="logo mb-3">
                <h2>Log Masuk Pengguna</h2>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="telefon" class="form-label">No Telefon</label>
                            <input type="text" 
                                   class="form-control @error('telefon') is-invalid @enderror" 
                                   id="telefon" 
                                   name="telefon" 
                                   value="{{ old('telefon') }}" 
                                   placeholder="No Telefon" 
                                   required>
                            @error('telefon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Katalaluan</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Katalaluan" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Log Masuk</button>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('register') }}">Daftar Akaun Baru</a>
                            <a href="{{ route('forgot-password') }}">Lupa Kata Laluan?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 