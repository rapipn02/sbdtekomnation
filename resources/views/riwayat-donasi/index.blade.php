
@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Riwayat Donasi</h1>
            
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>
                                                No
                                            </th>
                                            <th>Nama Member</th>
                                            <th>Untuk</th>
                                            <th>Jumlah Donasi</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($riwayat as $data)
                                    <tr>
                                      <td>
                                       {{$loop->iteration}}
                                      </td>
                                      <td>{{ $data->user->name }}</td>
                                      <td>{{ $data->daftar->judul }}</td>
                                      <td>Rp{{ number_format($data->jumlah, 2, ',', '.');  }}</td>
                                      <td>{{strtoupper($data->metode_pembayaran)}}</td>
                                      <td>
                                        @if ($data->status == 'pending')
                                            <span class="btn btn-warning btn-sm" onclick="snap.pay('{{ $data->snap_token}}')">Bayar Sekarang</span>
                                            @elseif($data->status == 'expire')
                                            <span class="btn btn-danger btn-sm" >Tidak Luarsa</span>
                                        @elseif($data->status == 'settlement')
                                        <span class="btn btn-success btn-sm" >Terbayar</span>
                                        @endif
                                    </td>
                                  </tr>
                                  @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
