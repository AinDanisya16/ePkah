@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Tetapkan Vendor untuk Penghantaran</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.assign-vendor') }}">
                        @csrf
                        <input type="hidden" name="penghantaran_id" value="{{ $penghantaran->id }}">
                        
                        <div class="mb-3">
                            <label for="penghantaran_info" class="form-label">Maklumat Penghantaran:</label>
                            <div class="form-control-plaintext">
                                ID: {{ $penghantaran->id }}
                                <!-- Add other shipment details as needed -->
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="vendor_id" class="form-label">Pilih Vendor:</label>
                            <select name="vendor_id" id="vendor_id" class="form-control @error('vendor_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Vendor --</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vendor_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.penghantaran') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Tetapkan Vendor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 