@extends('pdf.layout')

@section('title', 'Laporan Pengembangan Diri')
@section('document_subtitle', 'Rencana Aksi & Pengembangan Diri')

@section('content')

<div class="section-title">Fokus Pengembangan Diri</div>
<div class="box">
    <p>{{ $summary ?? 'Laporan ini disusun untuk memandu Anda dalam mengembangkan potensi diri guna mencapai tujuan akademik dan karir Anda.' }}</p>
</div>

@php
    $riasecLabels = [
        'R' => 'Realistic',
        'I' => 'Investigative',
        'A' => 'Artistic',
        'S' => 'Social',
        'E' => 'Enterprising',
        'C' => 'Conventional'
    ];

    $traitLabels = [
        'O' => 'Openness',
        'C' => 'Conscientiousness',
        'E' => 'Extraversion',
        'A' => 'Agreeableness',
        'N' => 'Neuroticism'
    ];

    $topRiasec = collect($result->input_riasec ?? [])->sortDesc()->keys()->take(3)->toArray();
    $topBigFive = collect($result->input_trait ?? [])->sortDesc()->keys()->take(3)->toArray();
@endphp

<div class="section-title">Eksplorasi Pengembangan Diri</div>
<div class="box">
    <p>Halaman ini menyajikan saran pengembangan diri untuk mengoptimalkan potensi dan mengatasi tantangan berdasarkan profil unik Anda.</p>
</div>

<div class="section-title">1. Katalisator Kemampuan (Penguat Karakter Utama)</div>
<div class="box">
    <p><strong>Penguat:</strong> {{ implode(', ', array_map(fn($k) => $riasecLabels[$k] ?? $k, array_slice($topRiasec, 0, 2))) }}, {{ $traitLabels[$topBigFive[0]] ?? $topBigFive[0] }}</p>
    <p><strong>Fokus Pengembangan:</strong> Memperkuat domain dominan Anda tidak harus selalu melalui jalur teknis yang linier. Kemampuan dapat diasah secara tak langsung—seperti berorganisasi untuk melatih kedisiplinan ({{ $traitLabels[$topBigFive[0]] ?? '' }}), hingga aktivitas yang menstimulasi nalar kritis ({{ $riasecLabels[$topRiasec[1]] ?? '' }}) dan ketahanan ({{ $riasecLabels[$topRiasec[0]] ?? '' }}).</p>
    <p><strong>Jalur Pengembangan:</strong></p>
    <ul>
        <li>Praktik Langsung: Mengikuti program magang atau kompetisi yang relevan untuk menguji keandalan Anda dalam domain {{ $riasecLabels[$topRiasec[0]] ?? '' }}.</li>
        <li>Stimulasi Kognitif: Gunakan media (film/buku) yang menantang nalar analitis Anda sesuai profil {{ $riasecLabels[$topRiasec[1]] ?? '' }}.</li>
        <li>Penguatan Karakter: Aktif di organisasi kampus untuk mengelola tanggung jawab yang mengasah {{ $traitLabels[$topBigFive[0]] ?? '' }} Anda.</li>
    </ul>
    <p><em>Dampak Positif: Memaksimalkan keunggulan kompetitif Anda di dunia profesional masa depan.</em></p>
</div>

<div class="section-title">2. Pelepas Stres (Penyeimbang Mental)</div>
<div class="box">
    <p><strong>Fokus Aktivitas:</strong></p>
    <p>Dominasi {{ $riasecLabels[$topRiasec[0]] ?? '' }} menunjukkan Anda pulih melalui aktivitas nyata. Namun, profil {{ $traitLabels[$topBigFive[2] ?? $topBigFive[0]] ?? '' }} Anda menunjukkan Anda membutuhkan waktu sendiri untuk mengisi energi.</p>
    <p>Saran Penyeimbang: Pilihlah hobi yang melibatkan aktivitas fisik atau teknis namun bersifat individual. Ini akan menyegarkan pikiran tanpa menguras energi sosial Anda.</p>
    <p><strong>Contoh Kegiatan:</strong></p>
    <ul>
        <li>Pemulihan Fisik: Olahraga solo terstruktur seperti berenang, lari, atau yoga.</li>
        <li>Kreativitas Praktis: Proyek DIY (Do It Yourself), merakit, atau berkebun.</li>
        <li>Eksplorasi Lingkungan: Fotografi alam atau mendaki gunung yang minim interaksi sosial intensif.</li>
    </ul>
    <p><em>Dampak Positif: Menjaga stabilitas emosi dan mencegah burnout akademik/pekerjaan.</em></p>
</div>

<div class="page-break"></div>
<div class="section-title">3. Pembentukan Karakter (Area Evaluasi Diri)</div>
<div class="box">
    <p><strong>Fokus Perbaikan:</strong></p>
    <p>Profil ini mengindikasikan kecenderungan untuk menghindari konflik atau kurang teliti dalam situasi yang tidak terstruktur. Jika dibiarkan, ini dapat menghambat pertumbuhan karir di lingkungan yang dinamis.</p>
    <p><strong>Langkah Konkret:</strong></p>
    <ul>
        <li>Simulasi Tantangan: Ambil peran kepanitiaan kecil yang memaksa Anda bernegosiasi dan membuat keputusan.</li>
        <li>Manajemen Waktu: Gunakan teknik pomodoro atau jurnal harian untuk membangun kedisiplinan pada tugas yang kurang Anda minati.</li>
    </ul>
    <p><em>Dampak Positif: Meningkatkan ketahanan mental (resiliensi) dan fleksibilitas karir.</em></p>
</div>

@endsection
