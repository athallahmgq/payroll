<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $gaji->karyawan->nama }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/qrcode.js/lib/qrcode.min.js"></script>
    <style>
        :root {
            --primary: #316A4E;
            --primary-light: #E9FFE6;
            --primary-dark: #265a40;
            --accent: #FFB8AB;
            --text-dark: #1F2937;
            --text-medium: #4B5563;
            --text-light: #6B7280;
            --border: #E5E7EB;
            --background: #FFFFFF;
            --background-alt: #F9FAFB;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --info: #3B82F6;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: #F3F4F6;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: var(--background);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            position: relative;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(49, 106, 78, 0.03);
            font-weight: 800;
            pointer-events: none;
            white-space: nowrap;
            z-index: 0;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.8;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            background-color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
            color: var(--primary);
            margin-right: 12px;
        }
        
        .company-name {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }
        
        .company-address {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 2px;
            font-weight: 300;
        }
        
        .document-title {
            margin-top: 20px;
            font-size: 16px;
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.15);
            padding: 8px 20px;
            border-radius: 30px;
            display: inline-block;
            letter-spacing: 1px;
            text-transform: uppercase;
            backdrop-filter: blur(5px);
        }
        
        .content {
            padding: 32px;
            position: relative;
            z-index: 1;
        }
        
        .section {
            margin-bottom: 32px;
            position: relative;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--primary);
            display: flex;
            align-items: center;
            letter-spacing: -0.3px;
        }
        
        .section-title i {
            margin-right: 10px;
            background-color: var(--primary-light);
            color: var(--primary);
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .employee-info {
            background-color: var(--background-alt);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .employee-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--primary-light));
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 4px;
            font-weight: 500;
        }
        
        .info-value {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .table-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            background-color: white;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background-color: var(--primary-light);
            color: var(--primary);
            text-align: left;
            padding: 14px 20px;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.3px;
        }
        
        td {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
        }
        
        tr:hover td {
            background-color: rgba(249, 250, 251, 0.5);
        }
        
        .total-row {
            background-color: var(--primary-light);
            font-weight: bold;
        }
        
        .total-row td {
            border-top: 1px solid rgba(49, 106, 78, 0.2);
        }
        
        .amount {
            text-align: right;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-variant-numeric: tabular-nums;
        }
        
        .negative {
            color: var(--danger);
        }
        
        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .qr-code {
            width: 120px;
            height: 120px;
            background-color: white;
            border: 1px solid var(--border);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .qr-code-label {
            font-size: 10px;
            color: var(--text-light);
            text-align: center;
            margin-top: 6px;
            font-weight: 500;
        }
        
        .signature-section {
            text-align: right;
        }
        
        .date {
            margin-bottom: 8px;
            color: var(--text-medium);
            font-size: 13px;
        }
        
        .signature {
            margin-top: 60px;
            margin-bottom: 8px;
        }
        
        .signature-name {
            font-weight: 600;
        }
        
        .signature-title {
            font-size: 13px;
            color: var(--text-light);
        }
        
        .signature-line {
            margin-top: 8px;
            border-top: 1px solid var(--text-dark);
            width: 200px;
            display: inline-block;
        }
        
        .print-button {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 32px auto;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(49, 106, 78, 0.2), 0 2px 4px -1px rgba(49, 106, 78, 0.1);
        }
        
        .print-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(49, 106, 78, 0.2), 0 4px 6px -2px rgba(49, 106, 78, 0.1);
        }
        
        .print-button:active {
            transform: translateY(0);
        }
        
        .print-button i {
            margin-right: 8px;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1;
        }
        
        .badge i {
            margin-right: 5px;
            font-size: 10px;
        }
        
        .badge-primary {
            background-color: var(--primary-light);
            color: var(--primary);
        }
        
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }
        
        .summary-card {
            background-color: white;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
        }
        
        .summary-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .summary-icon.primary {
            background-color: var(--primary-light);
            color: var(--primary);
        }
        
        .summary-icon.danger {
            background-color: #FEE2E2;
            color: var(--danger);
        }
        
        .summary-content {
            flex-grow: 1;
        }
        
        .summary-label {
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 2px;
        }
        
        .summary-value {
            font-weight: 700;
            font-size: 18px;
            color: var(--text-dark);
        }
        
        @media print {
            body {
                padding: 0;
                background-color: white;
            }
            
            .container {
                box-shadow: none;
                max-width: 100%;
            }
            
            .no-print {
                display: none;
            }
        }
        
        @media (max-width: 640px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .summary-cards {
                grid-template-columns: 1fr;
            }
            
            .footer {
                flex-direction: column;
                align-items: center;
            }
            
            .qr-code {
                margin-bottom: 24px;
            }
            
            .signature-section {
                text-align: center;
            }
            
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="watermark">QINTARA</div>
        
        <div class="header">
            <div class="logo-container">
                <div class="logo">Q</div>
                <div class="company-name">PT. QINTARA</div>
            </div>
            <div class="company-address">Jl. Contoh Alamat No. 123, Kota, Provinsi, Kode Pos</div>
            <div class="company-address">Telp: (021) 123-4567 | Email: info@perusahaan.com</div>
            <div class="document-title">Slip Gaji Karyawan</div>
        </div>
        
        <div class="content">
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-icon primary">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-label">Total Gaji Bersih</div>
                        <div class="summary-value">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</div>
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-icon danger">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-label">Total Potongan</div>
                        <div class="summary-value">Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            
            <div class="employee-info">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nama Karyawan</div>
                        <div class="info-value">{{ $gaji->karyawan->nama }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Periode</div>
                        <div class="info-value">{{ $bulanList[$gaji->bulan] }} {{ $gaji->tahun }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">NIK</div>
                        <div class="info-value">{{ $gaji->karyawan->nik }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tanggal Pembayaran</div>
                        <div class="info-value">{{ date('d F Y', strtotime($gaji->tanggal_pembayaran)) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Jabatan</div>
                        <div class="info-value">{{ $gaji->karyawan->posisi ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Departemen</div>
                        <div class="info-value">{{ $gaji->karyawan->departemen ?? '-' }}</div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">
                    <i class="fas fa-money-bill-wave"></i> Rincian Gaji
                </div>
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Komponen</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                        <tr>
                            <td>Gaji Pokok</td>
                            <td class="amount">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Potongan (Ketidakhadiran: {{ $gaji->total_tanpa_keterangan }} hari x Rp 50.000)</td>
                            <td class="amount negative">- Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="total-row">
                            <td>Gaji Bersih</td>
                            <td class="amount">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">
                    <i class="fas fa-calendar-check"></i> Rincian Kehadiran
                </div>
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Keterangan</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="badge badge-primary">
                                    <i class="fas fa-check-circle"></i> Hadir
                                </div>
                            </td>
                            <td class="amount">{{ $gaji->total_hadir }} hari</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="badge" style="background-color: #DBEAFE; color: #1E40AF;">
                                    <i class="fas fa-info-circle"></i> Izin
                                </div>
                            </td>
                            <td class="amount">{{ $gaji->total_izin }} hari</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="badge" style="background-color: #FEF3C7; color: #92400E;">
                                    <i class="fas fa-procedures"></i> Sakit
                                </div>
                            </td>
                            <td class="amount">{{ $gaji->total_sakit }} hari</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="badge" style="background-color: #FEE2E2; color: #B91C1C;">
                                    <i class="fas fa-times-circle"></i> Tanpa Keterangan
                                </div>
                            </td>
                            <td class="amount">{{ $gaji->total_tanpa_keterangan }} hari</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="footer">
                <div class="qr-code">
                    <div id="qrcode"></div>
                    <div class="qr-code-label">Scan untuk verifikasi</div>
                </div>
                
                <div class="signature-section">
                    <div class="date">{{ date('d F Y') }}</div>
                    <div class="signature">
                        <div class="signature-title">Mengetahui,</div>
                        <div class="signature-name">HRD / Manajer Keuangan</div>
                    </div>
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="no-print">
        <button onclick="window.print()" class="print-button">
            <i class="fas fa-print"></i> Cetak Slip Gaji
        </button>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create QR code data with salary information
            const qrData = {
                company: "PT. QINTARA",
                employee: "{{ $gaji->karyawan->nama }}",
                nik: "{{ $gaji->karyawan->nik }}",
                period: "{{ $bulanList[$gaji->bulan] }} {{ $gaji->tahun }}",
                salary: "{{ $gaji->gaji_bersih }}",
                date: "{{ date('Y-m-d', strtotime($gaji->tanggal_pembayaran)) }}",
                id: "{{ $gaji->id }}"
            };
            
            // Convert to JSON string
            const qrString = JSON.stringify(qrData);
            
            // Generate QR code
            const qrcode = new QRCode(document.getElementById("qrcode"), {
                text: qrString,
                width: 100,
                height: 100,
                colorDark: "#316A4E",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        });
    </script>
</body>
</html>