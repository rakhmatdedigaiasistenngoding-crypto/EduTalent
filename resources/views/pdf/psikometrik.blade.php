@extends('pdf.layout')

@section('title', 'Laporan Psikometrik')
@section('document_subtitle', 'Laporan Psikometrik')

@section('content')

<div class="section-title">Ringkasan Kepribadian Utama</div>
<div class="box">
    <p>{{ $summary ?? 'Profil kepribadian Anda menunjukkan perpaduan unik antara stabilitas dan potensi eksplorasi.' }}</p>
</div>

<div class="section-title">Hasil Tes RIASEC</div>
<table class="data-table">
    <thead>
        <tr>
            <th>Dimensi RIASEC</th>
            <th>Skor Mentah</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @php
            $riasecLabels = [
                'R' => 'Realistic (Praktis & Fisik)',
                'I' => 'Investigative (Analitis & Ilmiah)',
                'A' => 'Artistic (Kreatif & Ekspresif)',
                'S' => 'Social (Membantu & Mendidik)',
                'E' => 'Enterprising (Memimpin & Membujuk)',
                'C' => 'Conventional (Teratur & Detail)'
            ];
            $riasecData = $result->riasec_score ?? [];
            arsort($riasecData); // Urutkan tertinggi ke terendah
        @endphp
        @foreach($riasecData as $code => $score)
        <tr>
            <td class="bold">{{ $riasecLabels[$code] ?? $code }}</td>
            <td>{{ $score }}</td>
            <td>
                @if($score >= 15)
                    Sangat Dominan
                @elseif($score >= 10)
                    Kuat
                @else
                    Moderat
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="section-title">Profil Big Five (OCEAN)</div>
<table class="data-table">
    <thead>
        <tr>
            <th>Dimensi Karakter</th>
            <th>Kategori Tingkat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($traitMatriks['high'] ?? [] as $trait)
            <tr>
                <td class="bold">{{ ucfirst($trait) }}</td>
                <td>Tinggi (Kekuatan Utama)</td>
            </tr>
        @endforeach
        @foreach($traitMatriks['medium'] ?? [] as $trait)
            <tr>
                <td class="bold">{{ ucfirst($trait) }}</td>
                <td>Sedang (Seimbang)</td>
            </tr>
        @endforeach
        @foreach($traitMatriks['low'] ?? [] as $trait)
            <tr>
                <td class="bold">{{ ucfirst($trait) }}</td>
                <td>Rendah (Area Perhatian)</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="section-title">Work Values & Lingkungan Kerja</div>
<table class="data-table">
    <thead>
        <tr>
            <th>Kriteria</th>
            <th>Skor / Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result->work_value_score ?? [] as $key => $val)
        <tr>
            <td>Nilai Kerja: {{ ucfirst(str_replace('_', ' ', $key)) }}</td>
            <td class="bold">{{ $val }}</td>
        </tr>
        @endforeach
        
        @foreach($result->environment_score ?? [] as $key => $val)
        <tr>
            <td>Lingkungan: {{ ucfirst(str_replace('_', ' ', $key)) }}</td>
            <td class="bold">{{ $val }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
