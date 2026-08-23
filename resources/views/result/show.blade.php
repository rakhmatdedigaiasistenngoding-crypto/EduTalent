<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Hasil Rekomendasi - ShiroAsesmen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary: #4F46E5;
            --bg: #F9FAFB;
            --card-bg: #FFFFFF;
            --text-main: #111827;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --success: #10B981;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg); color: var(--text-main); line-height: 1.5; padding: 2rem 1rem; }
        .container-custom { max-width: 800px; margin: 0 auto; }
        
        header { margin-bottom: 2.5rem; text-align: center; }
        h1 { font-size: 2.25rem; font-weight: 700; margin-bottom: 0.5rem; }
        .badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; background: rgba(79, 70, 229, 0.1); color: var(--primary); font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem; }

        .result-card { background: var(--card-bg); border-radius: 1.25rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); padding: 2.5rem; border: 1px solid var(--border); margin-bottom: 2rem; position: relative; overflow: hidden; }
        .result-card::before { content: ""; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: var(--primary); }

        .profession-item { display: flex; align-items: center; justify-content: space-between; padding: 1.5rem; background: #F8FAFC; border-radius: 1rem; margin-bottom: 1rem; border: 1px solid #F1F5F9; transition: transform 0.2s; }
        .profession-item:hover { transform: translateX(8px); border-color: var(--primary); }
        
        .rank { font-size: 1.5rem; font-weight: 700; color: var(--primary); margin-right: 1.5rem; width: 40px; }
        .info { flex: 1; }
        .name { font-size: 1.25rem; font-weight: 600; margin-bottom: 0.25rem; }
        .match { font-size: 0.875rem; color: var(--text-muted); }

        .score-box { text-align: right; }
        .score-value { font-size: 1.5rem; font-weight: 700; color: var(--success); }
        .score-label { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; }

        .btn-back { display: inline-block; padding: 0.75rem 1.5rem; background: #F3F4F6; color: var(--text-main); text-decoration: none; border-radius: 0.75rem; font-weight: 600; transition: background 0.2s; }
        .btn-back:hover { background: #E5E7EB; }

        .details-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; margin-top: 0.5rem; }
        .detail-item { font-size: 0.75rem; color: var(--text-muted); background: white; padding: 2px 8px; border-radius: 4px; border: 1px solid #EDF2F7; }
    </style>
</head>
<body>
    <div class="container-custom">
        <!-- GLOBAL ALERTS -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span class="text-sm font-semibold">{{ session('warning') }}</span>
            </div>
        @endif
        
        <!-- PROMPT SMART DETECTION (BILA AUTHENTICATED & ADA DETEKSI SESI) -->
        @if(isset($context['potentialIdentity']) && $context['potentialIdentity'])
            <div x-data="{ showSmartDetect: true, loadingDetect: false, msgDetect: '', statusDetect: '' }" 
                 x-show="showSmartDetect"
                 x-transition
                 class="mb-8 border border-green-200 bg-green-50 p-6 rounded-2xl shadow-sm text-center relative" x-cloak>
                 
                <h3 class="text-lg font-bold text-green-900 mb-2">Kami menemukan data asesmen Anda sebelumnya ✨</h3>
                <p class="text-sm text-green-800 font-medium mb-4">Sistem mendeteksi ada hasil asesmen dari sesi Anda yang belum terhubung dengan akun ini.</p>
                
                <div x-show="msgDetect" x-text="msgDetect" :class="{'text-green-800 bg-green-100': statusDetect === 'success', 'text-red-800 bg-red-100': statusDetect === 'error'}" class="text-xs p-3 rounded-lg mb-4 inline-block font-medium" style="display: none;"></div>

                <div class="flex gap-3 justify-center">
                    <button @click="
                            loadingDetect = true; msgDetect = ''; statusDetect = '';
                            fetch('/api/link-session', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).then(res => res.json()).then(data => {
                                loadingDetect = false;
                                if(data.success) {
                                    statusDetect = 'success';
                                    msgDetect = data.message;
                                    setTimeout(() => window.location.reload(), 1500);
                                } else {
                                    statusDetect = 'error';
                                    msgDetect = data.message;
                                }
                            }).catch(err => {
                                loadingDetect = false;
                                statusDetect = 'error';
                                msgDetect = 'Terjadi kesalahan sistem.';
                            });
                        " 
                        class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow transition flex items-center justify-center min-w-[140px]">
                        <span x-show="!loadingDetect">Hubungkan Data</span>
                        <span x-show="loadingDetect" class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full" style="display: none;"></span>
                    </button>
                    <button @click="showSmartDetect = false" class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg transition">
                        Abaikan
                    </button>
                </div>
            </div>
        @endif

        <!-- PROMPT UI BILA GUEST -->
        @if(!$context['isAuthenticated'])
            <div x-data="{ showPrompt: true }" 
                 x-show="showPrompt" 
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-4"
                 class="mb-8 border border-indigo-100 bg-indigo-50 p-6 rounded-2xl shadow-sm">
                 
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-indigo-900 mb-1">Simpan hasil asesmen Anda</h3>
                        <p class="text-sm text-indigo-700 font-medium max-w-lg mb-4">
                            Hasil ini sementara hanya tersimpan di perangkat Anda. Buat akun atau login untuk menyimpan keamanan data asesmen secara permanen dan pantau riwayat perkembangan Anda.
                        </p>
                        <div class="flex gap-3">
                            <a href="#" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow transition">
                                Daftar / Login
                            </a>
                            <button @click="showPrompt = false" class="px-4 py-2.5 bg-white hover:bg-gray-50 border border-gray-200 text-gray-600 text-sm font-semibold rounded-lg transition">
                                Nanti saja
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- TOKEN INPUT BILA AUTHENTICATED -->
            <div x-data="{ showForm: false, token: '', message: '', status: '', loading: false }" class="mb-8 text-center" x-cloak>
                <button x-show="!showForm" @click="showForm = true" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition bg-indigo-50 hover:bg-indigo-100 px-4 py-2 rounded-full">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    Saya punya token
                </button>
                
                <div x-show="showForm" style="display: none;" 
                     x-transition class="mt-4 p-5 bg-white border border-gray-200 rounded-xl shadow-sm text-left max-w-sm mx-auto relative">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Masukkan Token Asesmen</label>
                    <input type="text" x-model="token" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm mb-3" placeholder="Contoh: TOK-...">
                    
                    <div x-show="message" x-text="message" :class="{'text-green-700 bg-green-50': status === 'success', 'text-red-700 bg-red-50': status === 'error'}" class="text-xs p-3 rounded-lg mb-3 font-medium"></div>
                    
                    <div class="flex gap-2">
                        <button @click="
                                if(!token) return;
                                loading = true; message = ''; status = '';
                                fetch('/api/link-token', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ token: token })
                                }).then(res => res.json()).then(data => {
                                    loading = false;
                                    if(data.success) {
                                        status = 'success';
                                        message = data.message;
                                        setTimeout(() => window.location.reload(), 1500);
                                    } else {
                                        status = 'error';
                                        message = data.message;
                                    }
                                }).catch(err => {
                                    loading = false;
                                    status = 'error';
                                    message = 'Terjadi kesalahan sistem.';
                                });
                            " 
                            class="flex-1 bg-indigo-600 text-white text-sm font-semibold py-2 rounded-lg hover:bg-indigo-700 transition flex justify-center items-center">
                            <span x-show="!loading">Hubungkan Token</span>
                            <span x-show="loading" class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full" style="display: none;"></span>
                        </button>
                        <button @click="showForm = false; token = ''; message = ''; status = '';" class="px-3 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 text-sm font-semibold rounded-lg transition">Batal</button>
                    </div>
                </div>
            </div>
        @endif        <!-- SECTION 1: PROFIL & METADATA -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-full -mr-10 -mt-10 opacity-50"></div>
            
            <div class="relative z-10">
                <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Halo, {{ $context['user']->name ?? 'Peserta' }}!</h2>
                        <div class="flex flex-wrap gap-2 text-sm">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full font-bold">Asesmen ke-{{ $assessmentCount ?? 1 }}</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full font-medium">{{ $result->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Status Profil</p>
                        <p class="text-lg font-bold text-indigo-600">
                            {{ $context['user']->status ?? '-' }} 
                            @if(isset($context['user']->origin)) 
                                <span class="text-gray-400 font-normal">di</span> {{ $context['user']->origin }}
                            @endif
                        </p>
                    </div>
                </div>

                <div class="p-6 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl text-white shadow-lg shadow-indigo-100">
                    <p class="text-lg leading-relaxed italic">
                        "Selamat datang kembali! Senang sekali bisa membantu Anda mengeksplorasi potensi diri hari ini. Hasil di bawah ini telah kami sesuaikan secara personal khusus untuk perjalanan karir Anda."
                    </p>
                </div>
            </div>
        </div>

        <!-- SECTION 2: KONTEKS ASESMEN (COLLAPSIBLE) -->
        <div x-data="{ open: false }" class="mb-8">
            <button @click="open = !open" class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition border border-gray-200">
                <div class="flex items-center gap-3">
                    <span class="text-xl">ℹ️</span>
                    <span class="font-bold text-gray-700">Tentang Asesmen Ini</span>
                </div>
                <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-collapse x-cloak class="mt-2 p-6 bg-white border border-gray-100 rounded-xl text-sm text-gray-600 leading-relaxed space-y-4">
                <p>Asesmen **ShiroAsesmen** menggunakan gabungan metode **Ipsative Trait Analysis**, **RIASEC Interest**, dan **Environmental Matching** untuk memetakan karakter dan minat Anda ke dalam 16 klaster profesi makro.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-3 bg-indigo-50 rounded-lg">
                        <p class="font-bold text-indigo-800 mb-1">Apa yang diukur?</p>
                        <p>Kecocokan gaya kerja, preferensi lingkungan, dan stabilitas minat antar waktu.</p>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-lg">
                        <p class="font-bold text-emerald-800 mb-1">Kenapa ini penting?</p>
                        <p>Membantu Anda mengambil keputusan pendidikan & profesi yang selaras dengan jati diri.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: RINGKASAN HASIL (SUMMARY) -->
        <div class="mb-8 text-center">
            <div class="inline-block p-1 bg-gray-100 rounded-full mb-4">
                <div class="px-6 py-2 bg-white rounded-full shadow-sm border border-gray-200">
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Skor Kecocokan Global</p>
                    <p class="text-4xl font-black text-indigo-600">{{ number_format(($result->top_score ?? 0) * 100, 1) }}%</p>
                </div>
            </div>
            <div class="max-w-2xl mx-auto">
                <p class="text-xl text-gray-700 font-medium leading-relaxed italic">
                    {!! isset($summary) ? '"' . $summary . '"' : 'Analisis sistem menunjukkan Anda memiliki potensi yang kuat di bidang yang membutuhkan kombinasi karakter analitis dan adaptabilitas tinggi.' !!}
                </p>
            </div>
        </div>

        <!-- SECTION 4: MATRIKS KARAKTER (3-COLUMN TABLE) -->
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden mb-12">
            <div class="bg-gray-50 px-8 py-4 border-b border-gray-100 flex items-center gap-2">
                <span class="text-xl">📊</span>
                <h3 class="font-bold text-gray-800">Matriks Dominansi Karakter</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <!-- LOW / TIDAK TERLALU KUAT -->
                <div class="p-8 bg-gray-50/30">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Potensi Terpendam</p>
                    <div class="space-y-3">
                        @foreach($traitMatriks['low'] ?? [] as $trait)
                            <div class="flex items-center gap-2 p-3 bg-white rounded-xl border border-gray-100 shadow-sm">
                                <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                <span class="text-sm font-semibold text-gray-600">{{ $trait }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- MEDIUM / SEDANG -->
                <div class="p-8">
                    <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-4">Kapasitas Pendukung</p>
                    <div class="space-y-3">
                        @foreach($traitMatriks['medium'] ?? [] as $trait)
                            <div class="flex items-center gap-2 p-3 bg-indigo-50/50 rounded-xl border border-indigo-100">
                                <div class="w-2 h-2 rounded-full bg-indigo-400"></div>
                                <span class="text-sm font-bold text-indigo-700">{{ $trait }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- HIGH / DOMINAN -->
                <div class="p-8 bg-indigo-600">
                    <p class="text-[10px] font-bold text-indigo-200 uppercase tracking-widest mb-4">Karakter Dominan</p>
                    <div class="space-y-3">
                        @foreach($traitMatriks['high'] ?? [] as $trait)
                            <div class="flex items-center gap-2 p-3 bg-white/10 rounded-xl border border-white/20">
                                <div class="w-2 h-2 rounded-full bg-yellow-400 shadow-[0_0_8px_#FACC15]"></div>
                                <span class="text-sm font-bold text-white">{{ $trait }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 5: RANKING REKOMENDASI BIDANG -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-black text-gray-900">Rekomendasi Bidang & Karir</h3>
                <span class="text-sm text-gray-500 font-medium italic">Urutan berdasarkan algoritma kecocokan terbaik</span>
            </div>

            <div class="space-y-6">
                @foreach($result->result_top_n ?? [] as $index => $item)
                    <div class="group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300 overflow-hidden">
                        <div class="flex flex-col lg:flex-row">
                            <!-- Left Info -->
                            <div class="lg:w-2/3 p-8">
                                <div class="flex items-center gap-4 mb-4">
                                    <span class="w-10 h-10 flex items-center justify-center bg-gray-900 text-white rounded-xl font-black text-lg">#{{ $index + 1 }}</span>
                                    <div>
                                        <h4 class="text-2xl font-bold text-gray-900">{{ $item['name'] }}</h4>
                                        <p class="text-sm text-indigo-600 font-bold uppercase tracking-wider">{{ $item['klaster'] ?? 'Bidang Utama' }}</p>
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                                        Pilihan karir ini sangat selaras dengan profil Anda yang cenderung **{{ $traitMatriks['high'][0] ?? 'dinamis' }}**. 
                                        Potensi kesuksesan di bidang ini sangat tinggi terutama jika didukung dengan pendidikan yang relevan.
                                    </p>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-gray-50 text-gray-500 text-[10px] font-bold rounded-lg border border-gray-100 uppercase">🎓 Jalur Pendidikan: {{ $educationPath['formal_s1'] ?? 'Relevan' }}</span>
                                        <span class="px-3 py-1 bg-gray-50 text-gray-500 text-[10px] font-bold rounded-lg border border-gray-100 uppercase">💼 Karir Terkait: {{ $item['related_jobs'] ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Stats (Responsive Indicator) -->
                            <div class="lg:w-1/3 bg-gray-50/50 p-8 flex flex-col justify-center border-t lg:border-t-0 lg:border-l border-gray-100">
                                <div class="mb-6">
                                    <div class="flex justify-between items-end mb-2">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kecocokan</span>
                                        <span class="text-2xl font-black text-indigo-600">{{ number_format(($item['score'] ?? 0) * 100, 1) }}%</span>
                                    </div>
                                    <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-indigo-600 rounded-full" style="width: {{ ($item['score'] ?? 0) * 100 }}%"></div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Indikator Pendukung</p>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-gray-500">Karakter Dasar</span>
                                        <span class="font-bold text-gray-700">{{ number_format(($item['details']['trait'] ?? 0) * 100, 0) }}%</span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-gray-500">Minat Minat</span>
                                        <span class="font-bold text-gray-700">{{ number_format(($item['details']['riasec'] ?? 0) * 100, 0) }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- SECTION 6: TAB DETAIL (PLACEHOLDER) -->
        <div class="mb-12 p-12 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200 text-center">
            <span class="text-4xl mb-4 block">🧪</span>
            <h4 class="text-lg font-bold text-gray-800 mb-2">Detail Mendalam Segera Hadir</h4>
            <p class="text-sm text-gray-500 max-w-sm mx-auto leading-relaxed">
                Kami sedang menyiapkan modul eksplorasi karir pendidikan dan profesi yang lebih detail untuk setiap bidang di atas.
            </p>
        </div>

        </div>

        <!-- [STEP-39A] USER FEEDBACK MECHANISM (REVISED UX) -->
        <div id="feedback-section" style="margin-top: 3rem; margin-bottom: 2rem; padding: 2.5rem; background: #ffffff; border-radius: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); opacity: 0; transform: translateY(20px); transition: all 0.8s ease-out;">
            <div id="feedback-form-container">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 0.5rem;">Seberapa sesuai hasil ini dengan diri Anda?</h3>
                    <p style="color: #64748b; font-size: 1rem;">Umpan balik Anda membantu kami menyempurnakan algoritma rekomendasi.</p>
                </div>
                
                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; margin-bottom: 1.5rem;">
                    @php
                        $options = [
                            1 => 'Tidak sesuai',
                            2 => 'Kurang sesuai',
                            3 => 'Cukup',
                            4 => 'Sesuai',
                            5 => 'Sangat sesuai'
                        ];
                    @endphp
                    @foreach($options as $score => $label)
                        <button type="button" class="feedback-option" data-value="{{ $score }}" style="flex: 1; min-width: 120px; padding: 1rem 0.5rem; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 1rem; color: #475569; cursor: pointer; transition: all 0.2s; text-align: center;">
                            <div style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem;">{{ $score }}</div>
                            <div style="font-size: 0.85rem; font-weight: 600;">{{ $label }}</div>
                        </button>
                    @endforeach
                </div>

                <div style="margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                    <textarea id="feedback-note" rows="3" placeholder="Ada catatan tambahan? (Opsional)" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #cbd5e1; font-family: inherit; font-size: 0.95rem; resize: vertical;"></textarea>
                </div>

                <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                    <button type="button" id="skip-feedback" style="padding: 0.75rem 2rem; background: transparent; color: #64748b; border: 1px solid #cbd5e1; border-radius: 0.75rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        Lewati
                    </button>
                    <button type="button" id="submit-feedback" disabled style="padding: 0.75rem 3rem; background: #94a3b8; color: white; border: none; border-radius: 0.75rem; font-weight: 700; cursor: not-allowed; transition: all 0.3s; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                        Kirim Feedback
                    </button>
                </div>
            </div>

            <div id="feedback-success" style="display: none; text-align: center; padding: 1.5rem;">
                <div style="font-size: 4rem; margin-bottom: 1.5rem; animation: bounce 1s infinite;">✨</div>
                <h3 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 0.5rem;">Terima kasih, ini membantu kami meningkatkan sistem</h3>
                <p style="color: #64748b; font-size: 1.1rem;">Feedback Anda telah dicatat dengan baik.</p>
            </div>
        </div>

        <style>
            @keyframes bounce {
                0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8, 0, 1, 1); }
                50% { transform: translateY(0); animation-timing-function: cubic-bezier(0, 0, 0.2, 1); }
            }
            .feedback-option.active {
                background: #eff6ff !important;
                border-color: #3b82f6 !important;
                color: #2563eb !important;
                transform: translateY(-4px);
                box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
            }
            .feedback-option:hover:not(.active) {
                background: #f1f5f9;
                border-color: #cbd5e1;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Timing Feedback: Tampilkan form dengan delay dan animasi setelah scroll atau 2 detik
                setTimeout(() => {
                    const feedbackSection = document.getElementById('feedback-section');
                    if (feedbackSection) {
                        feedbackSection.style.opacity = '1';
                        feedbackSection.style.transform = 'translateY(0)';
                    }
                }, 2000);

                const options = document.querySelectorAll('.feedback-option');
                const submitBtn = document.getElementById('submit-feedback');
                const skipBtn = document.getElementById('skip-feedback');
                const noteField = document.getElementById('feedback-note');
                let selectedRating = null;

                options.forEach(option => {
                    option.addEventListener('click', function() {
                        // Reset all
                        options.forEach(opt => opt.classList.remove('active'));
                        
                        // Set active
                        this.classList.add('active');
                        selectedRating = this.getAttribute('data-value');
                        
                        // Enable button
                        submitBtn.disabled = false;
                        submitBtn.style.background = '#2563eb';
                        submitBtn.style.cursor = 'pointer';
                    });
                });

                function hideFormShowSuccess() {
                    document.getElementById('feedback-form-container').style.display = 'none';
                    document.getElementById('feedback-success').style.display = 'block';
                }

                skipBtn.addEventListener('click', function() {
                    const feedbackSection = document.getElementById('feedback-section');
                    feedbackSection.style.opacity = '0';
                    feedbackSection.style.transform = 'translateY(20px)';
                    setTimeout(() => feedbackSection.style.display = 'none', 800);
                });

                submitBtn.addEventListener('click', function() {
                    if (!selectedRating) return;

                    submitBtn.disabled = true;
                    submitBtn.innerText = 'Mengirim...';

                    fetch('{{ route('feedback.submit') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            assessment_result_id: '{{ $result->id ?? 0 }}',
                            rating: selectedRating,
                            note: noteField.value.trim()
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            hideFormShowSuccess();
                        } else {
                            // If it's a duplicate or validation error
                            alert(data.message || 'Maaf, terjadi kesalahan. Silakan coba lagi.');
                            submitBtn.disabled = false;
                            submitBtn.innerText = 'Kirim Feedback';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan koneksi.');
                        submitBtn.disabled = false;
                        submitBtn.innerText = 'Kirim Feedback';
                    });
                });
            });
        </script>

        <footer style="margin-top: 3rem; text-align: center; font-size: 0.875rem; color: var(--text-muted);">

            &copy; {{ date('Y') }} ShiroAsesmen - Rakhmat Dedi G - EduProject
        </footer>
    </div>
</body>
</html>
