<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Laporan Asesmen')</title>
    <style>
        /* Standar CSS murni untuk DOMPDF */
        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #800000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
            border-collapse: collapse;
        }
        .header td {
            vertical-align: middle;
        }
        .logo-container {
            width: 80px;
            text-align: left;
        }
        .logo-container img {
            width: 70px;
            height: auto;
        }
        .univ-title {
            color: #800000;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            padding: 0;
        }
        .univ-subtitle {
            color: #D4AF37; /* Gold */
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin: 0;
            padding: 0;
        }
        .report-type {
            text-align: right;
            color: #800000;
        }
        .report-title {
            font-size: 20px;
            font-weight: bold;
            font-style: italic;
            text-transform: uppercase;
            margin: 0;
        }
        .report-subtitle {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }
        .user-info {
            width: 100%;
            margin-top: 10px;
            font-size: 10px;
            color: #555;
        }
        .user-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .user-info td.right {
            text-align: right;
            font-style: italic;
        }
        .section-title {
            color: #800000;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 15px;
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table.data-table th {
            background-color: #f5f5f5;
            color: #800000;
            font-weight: bold;
        }
        
        .box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fafafa;
        }
        .box-title {
            font-weight: bold;
            color: #800000;
            margin-bottom: 10px;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .italic { font-style: italic; }
        .mb-10 { margin-bottom: 10px; }
        .mb-20 { margin-bottom: 20px; }
        .mt-10 { margin-top: 10px; }
        .mt-20 { margin-top: 20px; }
        .clear { clear: both; }
        
        .page-break { page-break-after: always; }
        .avoid-break { page-break-inside: avoid; }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td class="logo-container">
                    <!-- Menggunakan public_path() agar DomPDF bisa mengakses gambar dari filesystem -->
                    @if(extension_loaded('gd'))
                        <img src="{{ public_path('assets/Teknokrat/logo UNIVERSITASTEKNOKRAT.png') }}" alt="Logo UTI">
                    @else
                        <!-- Fallback jika ekstensi GD tidak aktif -->
                        <div style="width: 70px; height: 70px; background: #800000; color: #FFD700; text-align: center; line-height: 70px; font-weight: bold; border-radius: 5px;">UTI</div>
                    @endif
                </td>
                <td>
                    <h1 class="univ-title">UNIVERSITAS TEKNOKRAT INDONESIA</h1>
                    <h2 class="univ-subtitle">KAMPUSNYA SANG JUARA</h2>
                </td>
                <td class="report-type">
                    <h1 class="report-title">ShiroAsesmen</h1>
                    <h2 class="report-subtitle">@yield('document_subtitle', 'Laporan Hasil Asesmen')</h2>
                </td>
            </tr>
        </table>
        
        <div class="user-info">
            <table>
                <tr>
                    <td>
                        <span class="bold">Nama:</span> {{ auth()->user()->name ?? 'Guest' }}<br>
                        <span class="bold">ID Asesmen:</span> SA-{{ \Carbon\Carbon::parse($result->created_at)->format('Ymd') }}-{{ sprintf('%03d', $result->id) }}
                    </td>
                    <td class="right">
                        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>

</body>
</html>
