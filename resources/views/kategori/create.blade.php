@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Kategori</h1>
           
        </div>

        <div class="section-body">
            <h2 class="section-title"> Form Tambah Data</h2>
            <div class="row">
                <div class="col-12">
                  
                    <div class="card">
                        <div class="card-body">
                            <form action="/dashboard/kategori" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <input type="text" class="form-control @error('kategori') is-invalid @enderror"
                                        required name="kategori">
                                    @error('kategori')
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
