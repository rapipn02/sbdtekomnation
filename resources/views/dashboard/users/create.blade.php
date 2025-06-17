@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manajemen Pengguna</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">Pengguna</a></div>
            <div class="breadcrumb-item">Tambah Pengguna</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form Tambah Pengguna Baru</h2>
        <p class="section-lead">
            Isi data-data berikut untuk menambahkan pengguna baru ke dalam sistem.
        </p>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Formulir Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dashboard.users.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Field Baru untuk Jenis Donatur --}}
                            <div class="form-group mb-3">
                                <label for="id_jenis">Jenis Donatur</label>
                                <select name="id_jenis" id="id_jenis" class="form-control @error('id_jenis') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis Donatur --</option>
                                    @foreach ($jenisDonatur as $jenis)
                                        {{-- Asumsi kolom di tabel jenis_donaturs adalah id_jenis dan jenis --}}
                                       <option value="{{ $jenis->id_jenis }}" {{ old('id_jenis') == $jenis->id_jenis ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis }}
                                    </option>
                                @endforeach
                                 </select>
                                  @error('id_jenis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                 @enderror
                            </div>

                            {{-- Field Baru untuk Nomor Telepon --}}

                            <div class="form-group mb-3">
                                <label for="is_admin">Peran (Role)</label>
                                <select name="is_admin" id="is_admin" class="form-control @error('is_admin') is-invalid @enderror" required>
                                    <option value="">-- Pilih Peran --</option>
                                    <option value="1" {{ old('is_admin') == '1' ? 'selected' : '' }}>Admin</option>
                                    <option value="0" {{ old('is_admin') == '0' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('is_admin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="password_confirmation">Konfirmasi Password</label>
                                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan Pengguna
                                </button>
                                <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection