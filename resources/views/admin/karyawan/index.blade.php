@extends('layouts.app')

@section('header', 'Kelola Data Karyawan')

@section('content')
    <a href="{{ route('admin.karyawan.create') }}" class="button button-green" style="margin-bottom: 15px;">Tambah Karyawan Baru</a>

    @if ($karyawans && $karyawans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIK</th>
                    <th>Posisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawans as $k_data) {{-- Menggunakan $k_data untuk menghindari konflik dengan $karyawan di scope global --}}
                    <tr>
                        <td>{{ $k_data->id }}</td>
                        <td>{{ $k_data->user->name }}</td>
                        <td>{{ $k_data->user->email }}</td>
                        <td>{{ $k_data->nik }}</td>
                        <td>{{ $k_data->posisi }}</td>
                        <td>
                            <a href="{{ route('admin.karyawan.show', $k_data->id) }}" class="button" style="background-color: #6cb2eb; margin-right:5px;">Lihat</a>
                            <a href="{{ route('admin.karyawan.edit', $k_data->id) }}" class="button" style="background-color: #ffed4a; color: #333; margin-right:5px;">Edit</a>
                            <form action="{{ route('admin.karyawan.destroy', $k_data->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan {{ $k_data->user->name }}? Ini juga akan menghapus data user terkait.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button button-red">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $karyawans->links() }}
        </div>
    @else
        <p>Belum ada data karyawan.</p>
    @endif
@endsection