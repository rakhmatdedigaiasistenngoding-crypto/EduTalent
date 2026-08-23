@php
    // Mapping indeks numerik ke label nama lengkap
    // Key di database adalah integer 0-5 (dari ScoringService::mapAnswersToVectors)
    $riasecLabels = [
        0 => 'Realistic (Realistis)',
        1 => 'Investigative (Investigatif)',
        2 => 'Artistic (Artistik)',
        3 => 'Social (Sosial)',
        4 => 'Enterprising (Wirausaha)',
        5 => 'Conventional (Konvensional)',
    ];
    $riasecCodes = [0=>'R', 1=>'I', 2=>'A', 3=>'S', 4=>'E', 5=>'C'];

    $traitLabels = [
        0 => 'Openness (Keterbukaan)',
        1 => 'Conscientiousness (Kehati-hatian)',
        2 => 'Extraversion (Ekstraversi)',
        3 => 'Agreeableness (Keramahan)',
        4 => 'Neuroticism (Stabilitas Emosi)',
    ];
    $traitCodes = [0=>'O', 1=>'C', 2=>'E', 3=>'A', 4=>'N'];

    $envLabels = [
        0 => 'Lingkungan Terstruktur',
        1 => 'Lingkungan Fleksibel',
        2 => 'Kerja Mandiri (Solo)',
        3 => 'Kerja Tim (Kolaboratif)',
        4 => 'Orientasi Sosial / Pelayanan',
        5 => 'Berorientasi Hasil & Kompetisi',
    ];

    $riasecData = collect($result->input_riasec ?? [])->sortDesc();
    $traitData  = collect($result->input_trait  ?? [])->sortDesc();
    $envData    = $result->input_environment ?? [];

    $topRiasec  = $riasecData->keys()->take(3)->toArray();
    $topBigFive = $traitData->keys()->take(3)->toArray();
    $top = $sortedTopN[0] ?? null;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Asesmen Lengkap</title>
<style>
body { font-family: Arial, sans-serif; color: #000; margin:0; padding:0; font-size:11px; line-height:1.5; }
.kop { width:100%; border-bottom:3px solid #800000; margin-bottom:12px; padding-bottom:8px; }
.kop table { width:100%; border-collapse:collapse; }
.kop td { vertical-align:middle; }
.logo-box { width:70px; height:70px; background:#800000; color:#FFD700; text-align:center; line-height:70px; font-weight:bold; border-radius:4px; font-size:18px; }
.univ-name { font-size:17px; font-weight:bold; color:#800000; text-transform:uppercase; margin:0; }
.univ-tag  { font-size:9px;  font-weight:bold; color:#D4AF37; letter-spacing:2px; text-transform:uppercase; margin:0; }
.doc-title { font-size:19px; font-weight:bold; font-style:italic; color:#800000; text-transform:uppercase; text-align:right; margin:0; }
.doc-sub   { font-size:9px; color:#666; text-transform:uppercase; text-align:right; letter-spacing:1px; }
.user-row  { font-size:10px; color:#444; margin-top:6px; }
.user-row table { width:100%; border-collapse:collapse; }

h2.sec { color:#800000; border-bottom:2px solid #800000; padding:4px 0; font-size:13px; margin:16px 0 8px 0; text-transform:uppercase; }
h3.sub { color:#800000; font-size:11px; margin:10px 0 4px 0; }
.box  { border:1px solid #ddd; padding:10px 14px; margin-bottom:10px; background:#fafafa; }
table.t { width:100%; border-collapse:collapse; margin-bottom:10px; }
table.t th { background:#f0e8e8; color:#800000; font-weight:bold; padding:6px 8px; border:1px solid #ddd; text-align:left; }
table.t td { padding:6px 8px; border:1px solid #ddd; }
table.t tr:nth-child(even) td { background:#fdfafa; }
.page-break { page-break-after:always; }
ul { margin:4px 0 8px 20px; padding:0; }
li { margin-bottom:3px; }
.badge { display:inline-block; background:#800000; color:#fff; padding:1px 6px; border-radius:3px; font-size:10px; }
.badge-gold { background:#D4AF37; color:#000; }
.right { text-align:right; }
.center { text-align:center; }
.bold { font-weight:bold; }
/* Nomor halaman - fixed footer dompdf */
.page-footer {
    position: fixed;
    bottom: -15mm;
    left: 0; right: 0;
    text-align: center;
    font-size: 9px;
    color: #888;
    border-top: 1px solid #ddd;
    padding-top: 4px;
}
.page-footer .page-num:after {
    content: counter(page);
}
.page-footer .page-total:after {
    content: counter(pages);
}
</style>
</head>
<body>

{{-- ====== KOP SURAT ====== --}}
<div class="kop">
    <table>
        <tr>
            <td style="width:85px;">
                @if(extension_loaded('gd'))
                    <img src="{{ public_path('assets/Teknokrat/logo UNIVERSITASTEKNOKRAT.png') }}" style="width:75px;height:auto;" alt="UTI">
                @else
                    <div class="logo-box">UTI</div>
                @endif
            </td>
            <td>
                <h1 class="univ-name">UNIVERSITAS TEKNOKRAT INDONESIA</h1>
                <h2 class="univ-tag">KAMPUSNYA SANG JUARA</h2>
            </td>
            <td>
                <div class="doc-title">ShiroAsesmen</div>
                <div class="doc-sub">Laporan Hasil Asesmen Mandiri Karakter</div>
            </td>
        </tr>
    </table>
    <div class="user-row">
        <table>
            <tr>
                <td>
                    <strong>Nama:</strong> {{ auth()->user()->name ?? ($result->identity->name ?? 'Guest') }}&nbsp;&nbsp;&nbsp;
                    <strong>ID Asesmen:</strong> SA-{{ \Carbon\Carbon::parse($result->created_at)->format('Ymd') }}-{{ sprintf('%03d', $result->id) }}&nbsp;&nbsp;&nbsp;
                    <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($result->created_at)->translatedFormat('d F Y') }}
                </td>
                <td class="right"><em>Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</em></td>
            </tr>
        </table>
    </div>
</div>

{{-- ====== BAGIAN 1: RINGKASAN EKSEKUTIF ====== --}}
<h2 class="sec">A. Ringkasan Eksekutif</h2>
<div class="box">
    <p>{{ $summary ?? 'Profil asesmen Anda menunjukkan perpaduan unik antara kekuatan karakter dan potensi karir.' }}</p>
    @if($top)
    <p><strong>Rekomendasi Profesi Utama:</strong> <span class="badge">{{ $top['profession'] ?? $top['name'] ?? '-' }}</span>&nbsp;
       <strong>Tingkat Kesesuaian:</strong> <span class="badge badge-gold">{{ number_format($top['score'] ?? 0, 1) }}%</span>
    </p>
    @endif
</div>

{{-- ====== BAGIAN 2: PROFIL PSIKOMETRIK ====== --}}
<h2 class="sec">B. Profil Psikometrik</h2>

<h3 class="sub">B.1 Skor RIASEC (Minat Karir)</h3>
<table class="t">
    <thead><tr><th>Kode</th><th>Dimensi Minat</th><th>Skor Kesesuaian</th><th>Kategori</th></tr></thead>
    <tbody>
    @foreach($riasecData as $idx => $score)
    @php $pct = round($score * 100, 1); @endphp
    <tr>
        <td class="center bold" style="width:40px;">{{ $riasecCodes[$idx] ?? $idx }}</td>
        <td class="bold">{{ $riasecLabels[$idx] ?? $idx }}</td>
        <td class="center">{{ $pct }}%</td>
        <td>@if($pct >= 75) Sangat Dominan @elseif($pct >= 50) Kuat @elseif($pct >= 25) Moderat @else Lemah @endif</td>
    </tr>
    @endforeach
    </tbody>
</table>

<h3 class="sub">B.2 Profil Big Five (OCEAN)</h3>
<table class="t">
    <thead><tr><th>Kode</th><th>Dimensi Kepribadian</th><th>Skor (%)</th><th>Kategori</th></tr></thead>
    <tbody>
    @foreach($traitData as $idx => $score)
    @php $pct = round($score * 100, 1); @endphp
    <tr>
        <td class="center bold" style="width:40px;">{{ $traitCodes[$idx] ?? $idx }}</td>
        <td class="bold">{{ $traitLabels[$idx] ?? $idx }}</td>
        <td class="center">{{ $pct }}%</td>
        <td>@if($pct >= 75) Tinggi @elseif($pct >= 40) Sedang @else Rendah @endif</td>
    </tr>
    @endforeach
    </tbody>
</table>

<h3 class="sub">B.3 Preferensi Lingkungan Kerja</h3>
@if(!empty($envData))
<table class="t">
    <thead><tr><th>#</th><th>Dimensi Lingkungan Kerja</th><th>Skor (%)</th><th>Kategori</th></tr></thead>
    <tbody>
    @foreach($envData as $idx => $val)
    @php $pct = round($val * 100, 1); @endphp
    <tr>
        <td class="center bold" style="width:30px;">{{ $idx }}</td>
        <td>{{ $envLabels[$idx] ?? 'Preferensi '.($idx+1) }}</td>
        <td class="center">{{ $pct }}%</td>
        <td>@if($pct >= 60) Kuat @elseif($pct >= 30) Sedang @else Lemah @endif</td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
<p>Data preferensi lingkungan kerja tidak tersedia.</p>
@endif

<div class="page-break"></div>

{{-- ====== BAGIAN 3: PETA PROFESI ====== --}}
<div class="kop">
    <table><tr>
        <td style="width:85px;">
            @if(extension_loaded('gd'))
                <img src="{{ public_path('assets/Teknokrat/logo UNIVERSITASTEKNOKRAT.png') }}" style="width:75px;height:auto;" alt="UTI">
            @else
                <div class="logo-box">UTI</div>
            @endif
        </td>
        <td><h1 class="univ-name">UNIVERSITAS TEKNOKRAT INDONESIA</h1><h2 class="univ-tag">KAMPUSNYA SANG JUARA</h2></td>
        <td><div class="doc-title">ShiroAsesmen</div><div class="doc-sub">Laporan Peta Profesi</div></td>
    </tr></table>
    <div class="user-row"><strong>Nama:</strong> {{ auth()->user()->name ?? ($result->identity->name ?? 'Guest') }} &nbsp;|&nbsp; <strong>ID:</strong> SA-{{ sprintf('%03d',$result->id) }}</div>
</div>

<h2 class="sec">C. Peta Profesi</h2>

@if($top)
<div class="box">
    <h3 class="sub" style="margin-top:0;">Rekomendasi Utama: {{ $top['profession'] ?? $top['name'] ?? '-' }}</h3>
    <p>{{ $reasons['main'] ?? $explanation['main'] ?? 'Profesi ini sangat selaras dengan minat utama Anda, nilai kerja, dan kekuatan kepribadian dominan Anda.' }}</p>
    <p><strong>Domain:</strong> {{ $top['domain'] ?? '-' }} &nbsp; <strong>Tingkat Kesesuaian:</strong> {{ number_format($top['score'] ?? 0, 1) }}%</p>
</div>

<h3 class="sub">C.1 Jalur Karir (Career Progression)</h3>
@php $cp = $careerPaths[0] ?? []; @endphp
@if(!empty($cp))
<table class="t">
    <thead><tr><th>Fase Karir</th><th>Posisi / Peran</th></tr></thead>
    <tbody>
    @foreach($cp as $phase => $role)
    <tr><td class="bold">{{ ucfirst($phase) }}</td><td>{{ $role }}</td></tr>
    @endforeach
    </tbody>
</table>
@else
<p>Data jalur karir tidak tersedia.</p>
@endif

<h3 class="sub">C.2 Kesenjangan Keahlian (Skill Gap)</h3>
@if(!empty($skillGap))
<table class="t">
    <thead><tr><th>Keahlian yang Perlu Dikembangkan</th><th>Cara Mendapatkannya</th></tr></thead>
    <tbody>
    @foreach($skillGap as $item)
    <tr>
        <td class="bold">{{ $item['skill'] ?? '-' }}</td>
        <td>{{ $item['method'] ?? '-' }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
<p>Data skill gap tidak tersedia.</p>
@endif
@else
<div class="box"><p>Data rekomendasi profesi tidak tersedia.</p></div>
@endif

<h3 class="sub">C.3 Alternatif Profesi (Top 5)</h3>
@if(!empty($sortedTopN))
<table class="t">
    <thead><tr><th class="center">Rank</th><th>Profesi</th><th>Domain</th><th class="center">Kesesuaian</th></tr></thead>
    <tbody>
    @foreach(array_slice($sortedTopN, 0, 5) as $idx => $prof)
    <tr>
        <td class="center bold">{{ $idx + 1 }}</td>
        <td class="bold">{{ $prof['profession'] ?? $prof['name'] ?? '-' }}</td>
        <td>{{ $prof['domain'] ?? '-' }}</td>
        <td class="center">{{ number_format($prof['score'] ?? 0, 1) }}%</td>
    </tr>
    @endforeach
    </tbody>
</table>
@endif

<div class="page-break"></div>

{{-- ====== BAGIAN 4: PETA PENDIDIKAN ====== --}}
<div class="kop">
    <table><tr>
        <td style="width:85px;">
            @if(extension_loaded('gd'))
                <img src="{{ public_path('assets/Teknokrat/logo UNIVERSITASTEKNOKRAT.png') }}" style="width:75px;height:auto;" alt="UTI">
            @else
                <div class="logo-box">UTI</div>
            @endif
        </td>
        <td><h1 class="univ-name">UNIVERSITAS TEKNOKRAT INDONESIA</h1><h2 class="univ-tag">KAMPUSNYA SANG JUARA</h2></td>
        <td><div class="doc-title">ShiroAsesmen</div><div class="doc-sub">Laporan Peta Pendidikan</div></td>
    </tr></table>
    <div class="user-row"><strong>Nama:</strong> {{ auth()->user()->name ?? ($result->identity->name ?? 'Guest') }} &nbsp;|&nbsp; <strong>ID:</strong> SA-{{ sprintf('%03d',$result->id) }}</div>
</div>

<h2 class="sec">D. Peta Pendidikan</h2>

<h3 class="sub">D.1 Jalur Pendidikan yang Disarankan</h3>
@if(!empty($educationPath))
<table class="t">
    <thead><tr><th>Tingkat Pendidikan</th><th>Jurusan / Program yang Direkomendasikan</th><th>Alasan</th></tr></thead>
    <tbody>
    @foreach($educationPath as $edu)
    <tr>
        <td class="bold" style="width:80px;">{{ $edu['level'] ?? '-' }}</td>
        <td>{{ implode(', ', (array)($edu['majors'] ?? [])) }}</td>
        <td>{{ $edu['reason'] ?? '-' }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
<div class="box"><p>Data jalur pendidikan tidak tersedia.</p></div>
@endif

<div class="page-break"></div>

{{-- ====== BAGIAN 5: PENGEMBANGAN DIRI ====== --}}
<div class="kop">
    <table><tr>
        <td style="width:85px;">
            @if(extension_loaded('gd'))
                <img src="{{ public_path('assets/Teknokrat/logo UNIVERSITASTEKNOKRAT.png') }}" style="width:75px;height:auto;" alt="UTI">
            @else
                <div class="logo-box">UTI</div>
            @endif
        </td>
        <td><h1 class="univ-name">UNIVERSITAS TEKNOKRAT INDONESIA</h1><h2 class="univ-tag">KAMPUSNYA SANG JUARA</h2></td>
        <td><div class="doc-title">ShiroAsesmen</div><div class="doc-sub">Laporan Pengembangan Diri</div></td>
    </tr></table>
    <div class="user-row"><strong>Nama:</strong> {{ auth()->user()->name ?? ($result->identity->name ?? 'Guest') }} &nbsp;|&nbsp; <strong>ID:</strong> SA-{{ sprintf('%03d',$result->id) }}</div>
</div>

<h2 class="sec">E. Pengembangan Diri</h2>

<h3 class="sub">E.1 Katalisator Kemampuan (Penguat Karakter Utama)</h3>
<div class="box">
    <p><strong>Dimensi Dominan:</strong>
        {{ implode(', ', array_map(fn($k) => ($riasecLabels[$k] ?? 'Dimensi '.($k+1)), array_slice($topRiasec, 0, 2))) }},
        {{ $traitLabels[$topBigFive[0] ?? 0] ?? 'Dimensi Kepribadian Utama' }}
    </p>
    <p><strong>Fokus Pengembangan:</strong> Memperkuat dimensi dominan Anda tidak harus melalui jalur teknis yang linier.
    Kemampuan dapat diasah secara tak langsung — berorganisasi untuk melatih kedisiplinan
    ({{ $traitLabels[$topBigFive[0] ?? 0] ?? '' }}), aktivitas yang menstimulasi nalar kritis
    ({{ $riasecLabels[$topRiasec[1] ?? 1] ?? '' }}) dan ketahanan ({{ $riasecLabels[$topRiasec[0] ?? 0] ?? '' }}).</p>
    <ul>
        <li><strong>Praktik Langsung:</strong> Program magang atau kompetisi relevan di dimensi {{ $riasecLabels[$topRiasec[0] ?? 0] ?? '' }}.</li>
        <li><strong>Stimulasi Kognitif:</strong> Media/buku yang menantang nalar analitis, sesuai profil {{ $riasecLabels[$topRiasec[1] ?? 1] ?? '' }}.</li>
        <li><strong>Penguatan Karakter:</strong> Aktif organisasi kampus untuk mengasah {{ $traitLabels[$topBigFive[0] ?? 0] ?? '' }}.</li>
    </ul>
</div>

<h3 class="sub">E.2 Simulasi Pertumbuhan (Growth Simulation)</h3>
@if(!empty($growthSimulation))
<div class="box">
    <p><strong>Trait Fokus Pengembangan:</strong> {{ $growthSimulation['trait'] ?? '-' }}</p>
    <ul>
    @foreach($growthSimulation['narration'] ?? [] as $point)
        <li>{{ $point }}</li>
    @endforeach
    </ul>
</div>
@else
<div class="box"><p>Data simulasi pertumbuhan tidak tersedia.</p></div>
@endif

<h3 class="sub">E.3 Rencana Aksi Konkret (Action Plan)</h3>
@if(!empty($actionPlan))
<table class="t">
    <thead><tr><th>#</th><th>Langkah Aksi</th><th class="center">Prioritas</th></tr></thead>
    <tbody>
    @foreach((array)$actionPlan as $i => $plan)
    <tr>
        <td class="center bold">{{ $i + 1 }}</td>
        <td>{{ $plan }}</td>
        <td class="center">@if($i < 2) Tinggi @elseif($i < 4) Sedang @else Normal @endif</td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
<div class="box"><p>Data rencana aksi tidak tersedia.</p></div>
@endif

<h3 class="sub">E.4 Skenario Pengembangan (Alternatif Fokus)</h3>
@if(!empty($scenarioResults))
<table class="t">
    <thead><tr><th>Skenario</th><th>Profesi Teratas</th><th class="center">Δ Skor</th></tr></thead>
    <tbody>
    @foreach($scenarioResults as $key => $res)
        @if($key !== 'current')
        <tr>
            <td class="bold">{{ $res['label'] ?? ucfirst($key) }}</td>
            <td>{{ $res['top_profession']['profession'] ?? $res['top_profession']['name'] ?? '-' }}</td>
            <td class="center">
                @php $diff = $res['score_diff'] ?? 0; @endphp
                @if($diff > 0) <span style="color:green;">+{{ number_format($diff,1) }}</span>
                @elseif($diff < 0) <span style="color:red;">{{ number_format($diff,1) }}</span>
                @else <span>Tetap</span>
                @endif
            </td>
        </tr>
        @endif
    @endforeach
    </tbody>
</table>
@else
<div class="box"><p>Data skenario tidak tersedia.</p></div>
@endif

{{-- ====== FOOTER TETAP (NOMOR HALAMAN) ====== --}}
<div class="page-footer">
    &copy; 2026 ShiroAsesmen &mdash; Universitas Teknokrat Indonesia &mdash; Laporan ini untuk kepentingan bimbingan akademik
    &nbsp;&nbsp;|&nbsp;&nbsp; Halaman <span class="page-num"></span> dari <span class="page-total"></span>
</div>

</body>
</html>
