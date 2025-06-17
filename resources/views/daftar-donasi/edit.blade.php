@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Daftar Donasi</h1>
            {{-- PERBAIKAN: Tag </div> yang berlebih sudah dihapus dari sini --}}
        </div>

        <div class="section-body">
            <h2 class="section-title"> Form Edit Data</h2>
            <div class="row">
                <div class="col-12">
                  
                    <div class="card">
                        <div class="card-body">
                            <form action="/dashboard/daftar-donasi/{{ $daftar->id }}" method="POST" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="form-group mb-2">
                                    <label>Judul</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                        required name="judul" value="{{ $daftar->judul }}">
                                    @error('judul')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-2">
                                    <label for="katgeori">Kategori</label>
                                    <select name="kategori_id" id="" class="form-control">
                                        <option value="">--Pilih--</option>
                                        @foreach ($kategoris as $kategori)
                                        @if ($daftar->kategori_id == $kategori->id)
                                              <option selected value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
                                        @else
                                        <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
                                        @endif
                                          
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Deskripsi</label>
                                    {{-- PERBAIKAN: Mengganti @error('juddeskripsiul') menjadi @error('deskripsi') --}}
                                    <textarea name="deskripsi" id="" cols="30" rows="10" class="form-control @error('deskripsi') is-invalid @enderror">{{ $daftar->deskripsi }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-2">
                                    <label>Foto</label>
                                    <input type="hidden" name="foto_lama" value="{{ $daftar->foto }}">
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                     name="foto">
                                    @error('foto')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection