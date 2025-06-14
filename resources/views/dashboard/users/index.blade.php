@extends('layouts.app') {{-- Sesuaikan jika nama layout utama Anda berbeda --}}

@section('title', 'Manajemen Pengguna') {{-- Judul Halaman Browser --}}

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Pengguna</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> {{-- Sesuaikan route dashboard utama Anda --}}
        <li class="breadcrumb-item active">Pengguna</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Pengguna
            <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary btn-sm float-end">
                <i class="fas fa-plus me-1"></i>
                Tambah Pengguna Baru
            </a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Foto</th>
                            <th>Peran</th>
                            <th>Email Terverifikasi</th>
                            <th>Bergabung Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto {{ $user->name }}" class="img-thumbnail" width="50">
                                @else
                                    <img src="{{ asset('path/to/default-avatar.png') }}" alt="Default Avatar" class="img-thumbnail" width="50"> {{-- Ganti dengan path avatar default Anda --}}
                                @endif
                            </td>
                            <td>
                                @if ($user->is_admin)
                                    <span class="badge bg-success">Admin</span>
                                @else
                                    <span class="badge bg-secondary">User</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->email_verified_at)
                                    <span class="badge bg-primary">{{ $user->email_verified_at->format('d M Y, H:i') }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <a href="{{ route('dashboard.users.show', $user->id) }}" class="btn btn-info btn-sm my-1" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-warning btn-sm my-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm my-1" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus pengguna ini: {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
    {{-- Jika Anda menggunakan DataTables atau styling CSS khusus untuk tabel ini --}}
    {{-- <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet"> --}}
    <style>
        .img-thumbnail {
            padding: .1rem; /* Sedikit padding untuk foto */
        }
        .breadcrumb-item a {
            text-decoration: none;
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
    </style>
@endpush

@push('scripts')
    {{-- Jika Anda menggunakan DataTables atau skrip JS khusus --}}
    {{-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> --}}
    {{-- <script>
        $(document).ready(function() {
            $('#usersTable').DataTable(); // Contoh inisialisasi DataTables
        });
    </script> --}}
@endpush