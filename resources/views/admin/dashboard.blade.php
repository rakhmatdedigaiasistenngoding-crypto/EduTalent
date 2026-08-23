<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ShiroAsesmen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-white border-b border-gray-200 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-indigo-600">ShiroAsesmen Admin</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ auth()->user()->name }} (Admin)</span>
                <a href="/" class="text-sm text-indigo-600 hover:underline">Lihat Situs</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Statistik Ringkas</h2>

        <!-- Grid Statistik Dasar -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium mb-1">Total Pengguna Terdaftar</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium mb-1">Total Asesmen Selesai</p>
                <p class="text-3xl font-bold text-indigo-600">{{ $totalAssessments }}</p>
            </div>
            <!-- [STEP-39B] Kualitas Rekomendasi -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium mb-1">Akurasi Rekomendasi (Feedback)</p>
                <div class="flex items-end gap-2">
                    <p class="text-3xl font-bold text-emerald-600">{{ $accuracyData['accuracy_percentage'] }}%</p>
                    <p class="text-sm font-semibold mb-1 {{ $accuracyData['status'] === 'Excellent' ? 'text-emerald-500' : 'text-amber-500' }}">
                        ({{ $accuracyData['status'] }})
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Tren Profesi -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6">5 Besar Tren Rekomendasi Profesi</h3>
                <div class="space-y-4">
                    @forelse($topProfessions as $name => $count)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">{{ $name }}</span>
                            <div class="flex items-center gap-3">
                                <div class="w-32 bg-gray-100 rounded-full h-2">
                                    <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ $totalAssessments > 0 ? ($count/$totalAssessments)*100 : 0 }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $count }}</span>
                             </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">Belum ada data tren.</p>
                    @endforelse
                </div>
            </div>

            <!-- [STEP-39B] Distribusi Feedback -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Distribusi Feedback Pengguna</h3>
                <div class="space-y-4">
                    @php
                        $colors = [
                            'Sangat sesuai' => 'bg-emerald-500',
                            'Cukup sesuai' => 'bg-blue-500',
                            'Kurang sesuai' => 'bg-amber-500',
                            'Tidak sesuai' => 'bg-rose-500'
                        ];
                    @endphp
                    @foreach(['Sangat sesuai', 'Cukup sesuai', 'Kurang sesuai', 'Tidak sesuai'] as $label)
                        @php $count = $feedbackDistribution[$label] ?? 0; @endphp
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">{{ $label }}</span>
                            <div class="flex items-center gap-3">
                                <div class="w-32 bg-gray-100 rounded-full h-2">
                                    <div class="{{ $colors[$label] }} h-2 rounded-full" style="width: {{ $accuracyData['total'] > 0 ? ($count/$accuracyData['total'])*100 : 0 }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $count }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 pt-6 border-top border-gray-100 flex justify-between text-sm">
                    <span class="text-gray-500">Total Responden:</span>
                    <span class="font-bold text-gray-900">{{ $accuracyData['total'] }}</span>
                </div>
            </div>
        </div>

        <!-- Kontrol Cepat -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Kontrol Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <a href="/health" target="_blank" class="flex items-center justify-between p-4 bg-indigo-50 rounded-xl text-indigo-700 hover:bg-indigo-100 transition-colors">
                    <span class="font-medium">Cek Kesehatan Sistem</span>
                    <span>→</span>
                </a>
                <button onclick="alert('Fitur segera hadir!')" class="flex items-center justify-between p-4 bg-gray-50 rounded-xl text-gray-700 hover:bg-gray-100 transition-colors">
                    <span class="font-medium">Ekspor Data (.csv)</span>
                    <span>→</span>
                </button>
            </div>
        </div>
    </main>
</body>
</html>
