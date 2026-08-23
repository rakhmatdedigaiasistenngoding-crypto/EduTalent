@extends('pdf.layout')

@section('title', 'Laporan Peta Pendidikan')
@section('document_subtitle', 'Laporan Peta Pendidikan')

@section('content')

<div class="section-title">Jurusan Pendidikan Rekomendasi</div>

@if(!empty($sortedTopN))
    @php
        $top = $sortedTopN[0];
    @endphp
    
    <div class="box">
        <h3 class="box-title">Rekomendasi Utama: {{ $top['profession'] ?? 'Jurusan Terkait' }}</h3>
        <p><strong>Skor Kecocokan:</strong> {{ number_format($decisionScore ?? 0, 1) }} / 100</p>
        <p><strong>Tingkat Keyakinan:</strong> {{ $top['confidence'] ?? 'Tinggi' }}</p>
        
        <p>{{ $explanation['main'] ?? 'Jurusan ini sangat sesuai dengan profil Anda berdasarkan nilai akademik dan minat kepribadian.' }}</p>
    </div>

    <div class="section-title">Jalur Pendidikan yang Disarankan</div>
    @if(!empty($educationPath['formal']))
        <table class="data-table">
            <thead>
                <tr>
                    <th>Gelar Formal</th>
                    <th>Fokus Studi Utama</th>
                </tr>
            </thead>
            <tbody>
                @foreach($educationPath['formal'] as $edu)
                    <tr>
                        <td class="bold">{{ $edu['degree'] ?? '-' }}</td>
                        <td>{{ $edu['focus'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada data jalur pendidikan formal spesifik untuk hasil ini.</p>
    @endif

    <div class="section-title">Sertifikasi & Keterampilan Alternatif</div>
    @if(!empty($educationPath['certifications']))
        <ul>
            @foreach($educationPath['certifications'] as $cert)
                <li>{{ $cert }}</li>
            @endforeach
        </ul>
    @endif

    <div class="page-break"></div>
    <div class="section-title">Alternatif Rekomendasi Lainnya</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Jurusan / Bidang</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach(array_slice($sortedTopN, 1, 5) as $idx => $prof)
            <tr>
                <td class="text-center">{{ $idx + 2 }}</td>
                <td class="bold">{{ $prof['profession'] }}</td>
                <td class="text-center">{{ number_format($prof['decision_score'] ?? $prof['score'] ?? 0, 1) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="box">
        <p>Data rekomendasi tidak tersedia untuk sesi asesmen ini.</p>
    </div>
@endif

@endsection
