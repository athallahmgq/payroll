@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hitung Gaji Karyawan</h3>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.gaji.hitung') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="karyawan_id">Karyawan</label>
                                    <select name="karyawan_id" id="karyawan_id" class="form-control" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id }}">{{ $karyawan->nama }} - {{ $karyawan->nik }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="bulan">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-control" required>
                                        @foreach ($bulanList as $key => $bulan)
                                            <option value="{{ $key }}" {{ date('n') == $key ? 'selected' : '' }}>{{ $bulan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <select name="tahun" id="tahun" class="form-control" required>
                                        @foreach ($tahunList as $key => $tahun)
                                            <option value="{{ $key }}" {{ date('Y') == $key ? 'selected' : '' }}>{{ $tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">Hitung Gaji</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Gaji Karyawan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="gaji-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>NIK</th>
                                    <th>Periode</th>
                                    <th>Kehadiran</th>
                                    <th>Gaji Pokok</th>
                                    <th>Potongan</th>
                                    <th>Gaji Bersih</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gajis as $index => $gaji)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $gaji->karyawan->nama ?? 'Nama tidak tersedia' }}</td>
                                    <td>{{ $gaji->karyawan->nik }}</td>
                                    <td>{{ $bulanList[$gaji->bulan] }} {{ $gaji->tahun }}</td>
                                    <td>
                                        Hadir: {{ $gaji->total_hadir }} kali<br>
                                        Izin: {{ $gaji->total_izin }} kali<br>
                                        Sakit: {{ $gaji->total_sakit }} kali<br>
                                        Tanpa Ket: {{ $gaji->total_tanpa_keterangan }} kali
                                    </td>
                                    <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.gaji.cetak', $gaji->id) }}" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fa fa-print"></i> Cetak Slip
                                        </a>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#gaji-table').DataTable({
            "ordering": false
        });
    });
</script>
@endpush