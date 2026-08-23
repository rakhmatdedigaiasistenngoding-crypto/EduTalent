<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Metrics</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-slate-800 mb-8">Metrics & Insights (Real User Feedback)</h1>

        <!-- Top Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                <h3 class="text-slate-500 text-sm font-medium">Total Feedback</h3>
                <p class="text-4xl font-bold text-indigo-600 mt-2">{{ $totalFeedback }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                <h3 class="text-slate-500 text-sm font-medium">Rata-rata Rating</h3>
                <p class="text-4xl font-bold text-emerald-600 mt-2">{{ number_format($averageRating, 1) }} <span class="text-sm text-slate-400 font-normal">/ 5.0</span></p>
            </div>
        </div>

        <!-- Distribution & Low Ratings -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Distribution Chart -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Distribusi Rating</h2>
                <div class="space-y-4">
                    @foreach([5 => 'Sangat sesuai', 4 => 'Sesuai', 3 => 'Cukup', 2 => 'Kurang sesuai', 1 => 'Tidak sesuai'] as $score => $label)
                        @php
                            $count = $distData[$score] ?? 0;
                            $percentage = $totalFeedback > 0 ? ($count / $totalFeedback) * 100 : 0;
                            
                            $colorClass = match($score) {
                                5 => 'bg-emerald-500',
                                4 => 'bg-emerald-400',
                                3 => 'bg-amber-400',
                                2 => 'bg-orange-400',
                                1 => 'bg-rose-500',
                                default => 'bg-slate-300'
                            };
                        @endphp
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700">⭐ {{ $score }} ({{ $label }})</span>
                                <span class="text-slate-500">{{ $count }} ({{ number_format($percentage, 0) }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5">
                                <div class="{{ $colorClass }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Insights (Low Ratings) -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                <h2 class="text-xl font-bold text-slate-800 mb-6 text-rose-600">Perlu Perhatian (Rating ≤ 2)</h2>
                @if(count($lowRatedResults) > 0)
                    <div class="space-y-4 max-h-80 overflow-y-auto">
                        @foreach($lowRatedResults as $fb)
                            <div class="p-4 border border-rose-100 bg-rose-50 rounded-lg">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-rose-100 text-rose-700 text-xs font-bold">
                                        ⭐ {{ $fb->rating }}
                                    </span>
                                    <span class="text-xs text-slate-400">{{ $fb->created_at->diffForHumans() }}</span>
                                </div>
                                @if($fb->assessmentResult)
                                    @php
                                        // Asumsikan data result_top_n ada (struktur json/array)
                                        $topProfessions = is_array($fb->assessmentResult->result_top_n) 
                                            ? collect($fb->assessmentResult->result_top_n)->pluck('profession_name')->take(3)->implode(', ')
                                            : 'N/A';
                                    @endphp
                                    <p class="text-sm font-medium text-slate-800 mb-1">Profesi Disarankan: <span class="font-normal">{{ $topProfessions }}</span></p>
                                @endif
                                @if($fb->note)
                                    <p class="text-sm text-slate-600 italic bg-white p-2 rounded border border-rose-100 mt-2">"{{ $fb->note }}"</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-slate-400">
                        <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Belum ada feedback dengan rating rendah.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
