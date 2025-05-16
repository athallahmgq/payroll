<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $gaji->karyawan->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-address {
            font-size: 12px;
            margin-bottom: 5px;
        }
        .document-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }
        .employee-info {
            margin-bottom: 20px;
        }
        .employee-info table {
            width: 100%;
        }
        .employee-info td {
            padding: 5px;
            vertical-align: top;
        }
        .salary-details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .salary-details th, .salary-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .salary-details th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
            margin-bottom: 20px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-name">PT. NAMA PERUSAHAAN</div>
            <div class="company-address">Jl. Contoh Alamat No. 123, Kota, Provinsi, Kode Pos</div>
            <div class="company-address">Telp: (021) 123-4567 | Email: info@perusahaan.com</div>
            <div class="document-title">SLIP GAJI KARYAWAN</div>
        </div>
        
        <div class="employee-info">
            <table>
                <tr>
                    <td width="150">Nama Karyawan</td>
                    <td width="20">:</td>
                    <td><strong>{{ $gaji->karyawan->nama }}</strong></td>
                    <td width="150">Periode</td>
                    <td width="20">:</td>
                    <td><strong>{{ $bulanList[$gaji->bulan] }} {{ $gaji->tahun }}</strong></td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{ $gaji->karyawan->nip }}</td>
                    <td>Tanggal Pembayaran</td>
                    <td>:</td>
                    <td>{{ date('d F Y', strtotime($gaji->tanggal_pembayaran)) }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $gaji->karyawan->jabatan ?? '-' }}</td>
                    <td>Departemen</td>
                    <td>:</td>
                    <td>{{ $gaji->karyawan->departemen ?? '-' }}</td>
                </tr>
            </table>
        </div>
        
        <table class="salary-details">
            <tr>
                <th colspan="2">RINCIAN GAJI</th>
            </tr>
            <tr>
                <td width="70%">Gaji Pokok</td>
                <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Potongan (Ketidakhadiran: {{ $gaji->total_tanpa_keterangan }} hari x Rp 50.000)</td>
                <td>- Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td>Gaji Bersih</td>
                <td>Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
            </tr>
        </table>
        
        <div>
            <h4>Rincian Kehadiran:</h4>
            <table class="salary-details">
                <tr>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
                <tr>
                    <td>Hadir</td>
                    <td>{{ $gaji->total_hadir }} hari</td>
                </tr>
                <tr>
                    <td>Izin</td>
                    <td>{{ $gaji->total_izin }} hari</td>
                </tr>
                <tr>
                    <td>Sakit</td>
                    <td>{{ $gaji->total_sakit }} hari</td>
                </tr>
                <tr>
                    <td>Tanpa Keterangan</td>
                    <td>{{ $gaji->total_tanpa_keterangan }} hari</td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            <div>{{ date('d F Y') }}</div>
            <div class="signature">
                <div>Mengetahui,</div>
                <div>HRD / Manajer Keuangan</div>
            </div>
            <div>(..................................)</div>
        </div>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px;">Cetak Slip Gaji</button>
    </div>
</body>
</html>