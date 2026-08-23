@extends('pdf.layout')

@section('title', 'Laporan Peta Profesi')
@section('document_subtitle', 'Laporan Peta Profesi')

@section('content')

<div class="section-title">Profesi Rekomendasi Utama</div>

@if(!empty($sortedTopN))
    @php
        $top = $sortedTopN[0];
    @endphp
    
    <div class="box">
        <h3 class="box-title">{{ $top['profession'] ?? 'Profesi Terkait' }}</h3>
        <p><strong>Kecocokan Karir:</strong> {{ number_format($decisionScore ?? 0, 1) }} / 100</p>
        <p><strong>Prospek:</strong> {{ $top['confidence'] ?? 'Sangat Menjanjikan' }}</p>
        <hr style="border:0; border-top:1px solid #ddd; margin: 10px 0;">
        <p>{{ $reasons['main'] ?? 'Profesi ini sangat selaras dengan minat utama Anda, nilai kerja yang Anda junjung, dan kekuatan kepribadian dominan Anda.' }}</p>
    </div>

    <div class="section-title">Jalur Karir (Career Path)</div>
    @if(!empty($careerPaths[0]))
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tahap Karir</th>
                    <th>Posisi / Peran</th>
                    <th>Estimasi Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($careerPaths[0]['steps'] ?? [] as $step)
                    <tr>
                        <td class="bold">{{ ucfirst($step['level'] ?? '-') }}</td>
                        <td>{{ $step['role'] ?? '-' }}</td>
                        <td>{{ $step['timeline'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Data jalur karir belum tersedia untuk profesi ini.</p>
    @endif

    <div class="section-title">Kesenjangan Keahlian (Skill Gap)</div>
    @if(!empty($skillGap))
        <div style="margin-bottom: 15px;">
            <strong>Keahlian yang Sudah Dimiliki (Bawaan):</strong><br>
            {{ implode(', ', $skillGap['current_strengths'] ?? ['-']) }}
        </div>
        <div style="margin-bottom: 15px;">
            <strong>Keahlian yang Perlu Dikembangkan:</strong><br>
            {{ implode(', ', $skillGap['needed_skills'] ?? ['-']) }}
        </div>
    @endif

    <div class="page-break"></div>
    <div class="section-title">Pilihan Karir Lainnya</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Profesi</th>
                <th>Skor Kesesuaian</th>
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
