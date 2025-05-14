@extends('layouts.app')

@section('header', 'Penggajian Karyawan')

@section('content')
    <div style="border: 1px solid #eee; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
        <h3>Hitung & Simpan Gaji Bulanan</h3>
        <form method="POST" action="{{ route('admin.gaji.hitung') }}">
            @csrf
            <div class="form-group">
                <label for="bulan_gaji">Pilih Bulan Gaji:</label>
                <select name="bulan_gaji" id="bulan_gaji" required>
                    @foreach($listBulan as $key => $namaBulan)
                        <option value="{{ $key }}" {{ $key == date('m') ? 'selected' : '' }}>{{ $namaBulan }}</option>
                    @endforeach
                </select>
                @error('bulan_gaji') <span class="error-message">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="tahun_gaji">Pilih Tahun Gaji:</label>
                <select name="tahun_gaji" id="tahun_gaji" required>
                    @for ($th = date('Y'); $th >= date('Y') - 5; $th--)
                        <option value="{{ $th }}" {{ $th == date('Y') ? 'selected' : '' }}>{{ $th }}</option>
                    @endfor
                </select>
                @error('tahun_gaji') <span class="error-message">{{ $message }}</span> @enderror
            </div>
            {{-- Opsional: Hitung untuk karyawan tertentu
            <div class="form-group">
                <label for="karyawan_id_gaji">Karyawan (Opsional, kosongkan untuk semua):</label>
                <select name="karyawan_id_gaji" id="karyawan_id_gaji">
                    <option value="">Semua Karyawan</option>
                    @foreach($karyawanList as $k_data)
                        <option value="{{ $k_data->id }}">{{ $k_data->user->name }} ({{ $k_data->nik }})</option>
                    @endforeach
                </select>
            </div>
            --}}
            <button type="submit" class="button">Hitung & Simpan Gaji</button>
        </form>
    </div>

    <hr>
    <h3>Daftar Gaji Sudah Diproses</h3>
    <form method="GET" action="{{ route('admin.gaji.index') }}" style="margin-bottom: 20px;">
        <label for="filter_bulan">Bulan:</label>
        <select name="filter_bulan" id="filter_bulan">
            @foreach($listBulan as $key => $namaBulan)
                <option value="{{ $key }}" {{ $key == $filterBulan ? 'selected' : '' }}>{{ $namaBulan }}</option>
            @endforeach
        </select>

        <label for="filter_tahun" style="margin-left: 10px;">Tahun:</label>
        <select name="filter_tahun" id="filter_tahun">
             @php $uniqueYears = array_unique(array_merge($listTahun->toArray(), [date('Y')])); rsort($uniqueYears); @endphp
            @foreach($uniqueYears as $th)
                <option value="{{ $th }}" {{ $th == $filterTahun ? 'selected' : '' }}>{{ $th }}</option>
            @endforeach
        </select>
        <button type="submit" style="margin-left: 10px;">Filter Daftar</button>
    </form>

    @if ($gajiList && $gajiList->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Periode</th>
                    <th>Gaji Pokok</th>
                    <th>Potongan</th>
                    <th>Gaji Bersih</th>
                    <th>Keterangan</th>
                    {{-- <th>Aksi</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($gajiList as $gaji)
                    <tr>
                        <td>{{ $gaji->karyawan->user->name }} ({{ $gaji->karyawan->nik }})</td>
                        <td>{{ \Carbon\Carbon::create()->month($gaji->bulan)->isoFormat('MMMM') }} {{ $gaji->tahun }}</td>
                        <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                        <td><strong>Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</strong></td>
                        <td>{{ $gaji->keterangan ?? '-' }}</td>
                        {{-- <td><a href="{{-- route('admin.gaji.slip', $gaji->id) --}}" class="button" target="_blank">Slip</a></td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $gajiList->appends(request()->query())->links() }}
        </div>
    @else
        <p>Tidak ada data gaji yang diproses untuk periode yang dipilih.</p>
    @endif
@endsection