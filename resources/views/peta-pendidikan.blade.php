<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>ShiroAsesmen - Peta Pendidikan</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
              "surface-bright": "#f8f9fa",
              "outline-variant": "#e2bfb9",
              "on-tertiary": "#ffffff",
              "surface": "#f8f9fa",
              "on-error": "#ffffff",
              "surface-dim": "#d9dadb",
              "tertiary-container": "#243d5e",
              "background": "#f8f9fa",
              "on-secondary-fixed-variant": "#544600",
              "secondary-container": "#fcd400",
              "primary-container": "#800000",
              "primary": "#570000",
              "on-surface": "#191c1d",
              "error": "#ba1a1a",
              "secondary-fixed-dim": "#e9c400",
              "error-container": "#ffdad6",
              "on-tertiary-fixed-variant": "#2f486a",
              "on-primary-container": "#ff8371",
              "on-secondary-fixed": "#221b00",
              "on-secondary-container": "#6e5c00",
              "inverse-primary": "#ffb4a8",
              "surface-container": "#edeeef",
              "secondary": "#705d00",
              "on-primary-fixed": "#410000",
              "on-primary": "#ffffff",
              "surface-container-low": "#f3f4f5",
              "on-surface-variant": "#5a413d",
              "on-tertiary-container": "#8fa8cf",
              "surface-container-high": "#e7e8e9",
              "tertiary-fixed": "#d4e3ff",
              "tertiary": "#0a2747",
              "tertiary-fixed-dim": "#afc8f0",
              "primary-fixed-dim": "#ffb4a8",
              "surface-container-highest": "#e1e3e4",
              "on-tertiary-fixed": "#001c3a",
              "on-error-container": "#93000a",
              "primary-fixed": "#ffdad4",
              "on-background": "#191c1d",
              "inverse-on-surface": "#f0f1f2",
              "surface-variant": "#e1e3e4",
              "surface-tint": "#b22b1d",
              "inverse-surface": "#2e3132",
              "surface-container-lowest": "#ffffff",
              "outline": "#8e706c",
              "secondary-fixed": "#ffe16d",
              "on-secondary": "#ffffff",
              "on-primary-fixed-variant": "#8f0f07"
            },
            "borderRadius": {
              "DEFAULT": "0.25rem",
              "lg": "0.5rem",
              "xl": "0.75rem",
              "full": "9999px"
            },
            "spacing": {
              "stack-lg": "32px",
              "margin": "32px",
              "container-max": "1280px",
              "unit": "8px",
              "stack-md": "16px",
              "stack-xl": "64px",
              "stack-sm": "8px",
              "gutter": "24px"
            },
            "fontFamily": {
              "body-lg": ["Inter"],
              "label-md": ["Inter"],
              "headline-md": ["Inter"],
              "display-lg": ["Inter"],
              "headline-lg": ["Inter"],
              "body-md": ["Inter"]
            },
            "fontSize": {
              "body-lg": ["19px", {"lineHeight": "1.6", "fontWeight": "400"}],
              "label-md": ["15px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "600"}],
              "headline-md": ["25px", {"lineHeight": "1.3", "fontWeight": "600"}],
              "display-lg": ["49px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "800"}],
              "headline-lg": ["33px", {"lineHeight": "1.2", "fontWeight": "700"}],
              "body-md": ["17px", {"lineHeight": "1.5", "fontWeight": "400"}]
            }
          }
        }
      }
    </script>
    <style>
        @media print {
            /* 1. Sembunyikan elemen UI Aplikasi */
            aside, nav, header, footer, button, #scrollToTopBtn, .no-print, [id$="Modal"], #sidebarOverlay, .sidebar {
                display: none !important;
            }
            
            /* 2. Setup Kertas & Reset Dasar */
            @page { size: A4 portrait; margin: 15mm; }
            html, body {
                background: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            /* 3. Bebaskan Layout dari constraint UI */
            .flex-1, .lg\:ml-64, main, .min-h-screen {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                display: block !important;
            }
            
            /* 4. Ubah SEMUA Kartu/Box menjadi Format Teks Biasa */
            div, section, article, .bg-surface-container-low, .bg-surface-container-lowest, .bg-surface, .bg-surface-variant {
                background: transparent !important;
                background-color: transparent !important;
                box-shadow: none !important;
                color: #000000 !important;
            }
            
            /* 5. Tampilkan Batas (Border) dengan warna abu-abu terang agar rapi */
            .border, .border-outline-variant, .border-surface-variant, [class*="border-"] {
                border-color: #cccccc !important;
                border-width: 1px !important;
                border-radius: 0 !important;
            }

            /* 6. Hilangkan warna-warni teks, paksa Hitam */
            h1, h2, h3, h4, h5, p, span, strong, .text-primary, .text-tertiary, .text-on-surface, .text-on-surface-variant {
                color: #000000 !important;
            }
            
            /* 7. Elemen Khusus Cetak */
            .print-only { display: block !important; }
            .print-hidden { display: none !important; }
            
            /* 8. Mencegah terpotong di tengah halaman */
            .break-inside-avoid, .glass-card, [class*="bg-surface"] {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
                margin-bottom: 15px !important;
            }
            
            .grid { display: block !important; }
            .grid > div { margin-bottom: 20px !important; break-inside: avoid !important; }
            
            /* 9. Matikan cetak background grafis dari Tailwind agar tinta hemat dan rapi */
            * { -webkit-print-color-adjust: economy !important; print-color-adjust: economy !important; }
            
            /* 10. Pertahankan warna Logo di Kop Surat */
            .print-only img { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
        @media screen {
            .print-only { display: none !important; }
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md selection:bg-primary-container selection:text-on-primary-container min-h-screen flex">
    
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
@endphp

    <!-- Sidebar Mobile Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden backdrop-blur-sm" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <nav id="sidebar" class="hidden lg:flex h-screen w-64 fixed left-0 top-0 bg-[#800000] z-50 flex-col py-6 text-white shadow-xl overflow-hidden no-print">
        <div class="px-6 mb-stack-lg text-center flex flex-col items-center">
            <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center mb-3 shadow-lg border-2 border-[#FFD700] p-1">
                <img alt="Logo UTI" class="w-full h-full object-contain" src="{{ asset('assets/Teknokrat/logo UNIVERSITASTEKNOKRAT.png') }}" onerror="this.src='https://ui-avatars.com/api/?name=UTI&background=fff&color=800000'"/>
            </div>
            <div>
                <h1 class="text-sm font-black tracking-tight text-white uppercase leading-tight">Universitas Teknokrat Indonesia</h1>
                <p class="text-[#FFD700] text-[10px] font-bold tracking-widest uppercase mt-1">Kampusnya Sang Juara</p>
            </div>
        </div>
        <div class="flex-1 flex flex-col gap-1 px-4">
            <a class="flex items-center gap-3 px-4 py-3 text-white/70 font-medium hover:text-white hover:bg-white/5 rounded-l-lg transition-colors duration-200" href="{{ route('dashboard.user') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-label-md text-label-md">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-white/70 font-medium hover:text-white hover:bg-white/5 rounded-l-lg transition-colors duration-200" href="{{ url('/psikometrik') }}">
                <span class="material-symbols-outlined">psychology</span>
                <span class="font-label-md text-label-md">Psikometrik</span>
            </a>
            <!-- Active Tab -->
            <a class="flex items-center gap-3 px-4 py-3 text-[#FFD700] font-bold bg-white/10 border-r-4 border-[#FFD700] rounded-l-lg transition-colors duration-200" href="{{ url('/peta-pendidikan') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">map</span>
                <span class="font-label-md text-label-md">Peta Pendidikan</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-white/70 font-medium hover:text-white hover:bg-white/5 rounded-l-lg transition-colors duration-200" href="{{ url('/peta-profesi') }}">
                <span class="material-symbols-outlined">work</span>
                <span class="font-label-md text-label-md">Peta Profesi</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-white/70 font-medium hover:text-white hover:bg-white/5 rounded-l-lg transition-colors duration-200" href="{{ url('/pengembangan-diri') }}">
                <span class="material-symbols-outlined">trending_up</span>
                <span class="font-label-md text-label-md">Pengembangan Diri</span>
            </a>
        </div>
        <div class="mt-auto relative h-1/3 w-full flex flex-col justify-end">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <img src="{{ asset('assets/Teknokrat/Gedung UTI Baru.png') }}" class="w-full h-full object-cover object-top opacity-50 mix-blend-screen">
                <div class="absolute inset-0 bg-gradient-to-b from-[#800000] via-[#800000]/10 to-transparent"></div>
            </div>
            <div class="px-6 pb-6 pt-12 relative z-10 flex flex-col gap-3">
                <button id="btnReview" onclick="performReview()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#FFD700] text-[#800000] rounded-lg font-bold shadow-md hover:bg-white transition-colors">
                    <span class="material-symbols-outlined">feedback</span> Review
                </button>
                <button id="btnExport" onclick="openExportModal()" data-locked="true" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white border border-[#800000] text-[#800000] opacity-60 rounded-lg font-bold shadow-none cursor-not-allowed transition-all duration-300">
                    <span class="material-symbols-outlined">share</span> Bagikan Hasil
                    <span class="material-symbols-outlined text-xs ml-auto" id="lockIcon">lock</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen relative">
        <header class="sticky top-0 w-full z-40 border-b border-surface-variant bg-surface-container-lowest/80 backdrop-blur-md shadow-none border-b-2 border-primary/10 no-print">
            <div class="flex items-center justify-between px-4 md:px-8 py-3 max-w-[1280px] mx-auto">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 -ml-2 text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="flex flex-col ml-2 md:ml-0">
                        <span class="text-xs font-semibold text-on-surface-variant tracking-widest uppercase">Shiro-Asesmen &bull; Hasil Asesmen</span>
                        <span class="text-lg font-bold text-primary font-headline-md text-headline-md">Peta Pendidikan</span>
                    </div>
                </div>
                <div class="flex items-center gap-3 md:gap-6">
                    <!-- Search Bar -->
                    <div class="relative hidden lg:block" id="searchContainer">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl">search</span>
                        <input id="smartSearchInput" class="pl-10 pr-4 py-2 bg-surface-container-low border-b-2 border-transparent focus:border-primary focus:bg-surface-container-lowest focus:ring-0 rounded-xl transition-all font-body-md text-sm w-48 xl:w-80 text-on-surface" placeholder="Cari bagian di halaman ini..." type="text" autocomplete="off"/>
                        
                        <!-- Search Results Dropdown -->
                        <div id="searchResults" class="absolute top-full left-0 w-full mt-2 bg-white border border-surface-variant rounded-xl shadow-xl hidden z-50 overflow-hidden">
                            <div id="resultsList" class="max-h-60 overflow-y-auto py-2">
                                <!-- Results will be injected here -->
                            </div>
                        </div>
                    </div>
                    <!-- Trailing Icons -->
                    <div class="flex items-center gap-1 sm:gap-2">
                        <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition-colors">
                            <span class="material-symbols-outlined">notifications</span>
                        </button>
                        <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition-colors" title="Chatbot AI">
                            <span class="material-symbols-outlined">help_outline</span>
                        </button>
                        <!-- Profile Section: Icon + Name -->
                        <div class="flex flex-col items-center gap-0 ml-2 min-w-[60px]">
                            <button class="p-1 text-on-surface-variant hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">account_circle</span>
                            </button>
                            <span class="text-[8px] font-extrabold text-on-surface-variant uppercase tracking-tighter leading-none whitespace-nowrap">{{ auth()->user()->name ?? 'Guest' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 p-4 md:p-8 max-w-[1280px] w-full mx-auto space-y-12">
            <!-- PRINT ONLY HEADER -->
            <div class="print-only mb-10 border-b-4 border-[#800000] pb-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/Teknokrat/logo UNIVERSITASTEKNOKRAT.png') }}" class="w-20 h-20 object-contain" onerror="this.src='https://ui-avatars.com/api/?name=UTI&background=fff&color=800000'">
                        <div>
                            <div class="text-2xl font-black text-[#800000] uppercase leading-tight">UNIVERSITAS TEKNOKRAT INDONESIA</div>
                            <div class="text-sm font-bold text-[#FFD700] tracking-[0.2em] uppercase">KAMPUSNYA SANG JUARA</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-black text-[#800000] tracking-tighter uppercase italic">ShiroAsesmen</div>
                        <div class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Laporan Hasil Akademik & Karakter</div>
                    </div>
                </div>
                <div class="flex justify-between items-end mt-4">
                    <div class="text-xs text-on-surface-variant">
                        <div class="font-bold">Nama: {{ auth()->user()->name ?? 'Guest' }}</div>
                        <div>ID Asesmen: SA-{{ \Carbon\Carbon::parse($result->created_at)->format('Ymd') }}-{{ sprintf('%03d', $result->id) }}</div>
                    </div>
                    <div class="text-xs text-on-surface-variant italic">Dicetak pada: <span id="printDate"></span></div>
                </div>
            </div>
            <div class="text-[10px] font-bold tracking-widest uppercase text-on-surface-variant mb-[-1rem]">
                SHIROASESMEN &bull; HASIL ASESMEN &bull; <span class="text-primary">PETA PENDIDIKAN</span>
            </div>

            <!-- 1. HERO SECTION -->
            <section class="mb-12 relative rounded-3xl overflow-hidden shadow-xl border border-surface-variant bg-gradient-to-br from-primary to-primary-container">
                <img src="{{ asset('assets/Teknokrat/Gedung Utama UTI.jpeg') }}" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-20">
                <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-transparent"></div>
                <div class="relative z-10 p-8 md:p-12 lg:w-3/4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-xs font-bold tracking-wider mb-6">
                        <span class="material-symbols-outlined text-sm">explore</span> THE ACADEMIC COMPASS
                    </div>
                    <h2 class="text-3xl md:text-5xl font-black text-white italic mb-4 tracking-tight uppercase leading-tight">Navigasi Jalur Akademik Anda</h2>
                    <p class="text-white/90 font-body-md md:font-body-lg mb-8 leading-relaxed max-w-3xl">
                        Peta pendidikan ini dirancang khusus untuk Anda. Rekomendasi di bawah ini merupakan hasil sinkronisasi mendalam antara <strong>Minat (RIASEC)</strong>, <strong>Karakter (Big Five)</strong>, dan <strong>Preferensi Lingkungan</strong> Anda, memastikan jalur yang dipilih selaras dengan potensi alami Anda.
                    </p>
                </div>
            </section>

            <!-- 2. REKOMENDASI BIDANG STUDI -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b-2 border-primary/20 pb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">school</span>
                    <h3 class="text-2xl font-bold text-on-surface">Rekomendasi Bidang Studi</h3>
                </div>
                <p class="text-on-surface-variant">Berikut adalah bidang studi yang diurutkan berdasarkan tingkat kecocokan tertinggi dengan profil Anda.</p>

                <div class="grid gap-6">
                    @foreach(collect($sortedTopN)->take(3) as $index => $prof)
                    @php
                        $isMain = $index === 0;
                        $score = round($prof['score'] ?? 0); // Score is already in %

                        // Derive primary RIASEC from user's input_riasec (numeric array: 0=R,1=I,2=A,3=S,4=E,5=C)
                        $riasecIndexMap = [0 => 'R', 1 => 'I', 2 => 'A', 3 => 'S', 4 => 'E', 5 => 'C'];
                        $inputRiasec = $result->input_riasec ?? [];
                        $topRiasecIndex = 0;
                        $topRiasecVal = -1;
                        foreach ($inputRiasec as $idx => $val) {
                            if ($val > $topRiasecVal) { $topRiasecVal = $val; $topRiasecIndex = $idx; }
                        }
                        $riasecCode = $riasecIndexMap[$topRiasecIndex] ?? 'R';
                        $primaryInterest = $riasecLabels[$riasecCode] ?? 'General';
                        
                        // Map icon based on RIASEC
                        $iconMap = [
                            'R' => 'engineering',
                            'I' => 'biotech',
                            'A' => 'palette',
                            'S' => 'groups',
                            'E' => 'trending_up',
                            'C' => 'account_balance'
                        ];
                        $icon = $iconMap[$riasecCode] ?? 'school';
                    @endphp
                    
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group {{ !$isMain ? 'opacity-95' : '' }}">
                        <div class="absolute top-0 right-0 {{ $isMain ? 'bg-secondary text-on-secondary' : 'bg-surface-variant text-on-surface-variant' }} px-4 py-1 rounded-bl-xl font-bold text-sm z-10">
                            {{ $isMain ? 'Pilihan Utama' : 'Alternatif Kuat' }}
                        </div>
                        <div class="absolute left-0 top-0 bottom-0 w-1 {{ $isMain ? 'bg-secondary' : 'bg-surface-variant' }}"></div>
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="md:w-1/4 flex flex-col justify-center items-center bg-surface-container-low rounded-xl p-6 border border-surface-variant group-hover:bg-primary/5 transition-colors">
                                <span class="material-symbols-outlined text-5xl text-primary mb-2">{{ $icon }}</span>
                                <h4 class="text-xl font-bold text-center text-on-surface">{{ $prof['name'] }}</h4>
                                <div class="mt-3 bg-white px-3 py-1 rounded-full text-sm font-semibold text-primary border border-primary/20">Kecocokan: {{ $score }}%</div>
                            </div>
                            <div class="md:w-3/4 flex flex-col justify-center">
                                <h5 class="text-lg font-bold text-on-surface mb-2">Mengapa Bidang Ini Cocok?</h5>
                                <p class="text-on-surface-variant leading-relaxed">
                                    Bidang <strong>{{ $prof['name'] }}</strong> sangat sesuai dengan profil <strong>{{ $primaryInterest }}</strong> Anda. Berdasarkan hasil analisis, kombinasi karakter dan minat Anda menunjukkan potensi besar untuk berkembang di jalur akademik ini. Ketelitian dan cara Anda memproses informasi selaras dengan tuntutan kompetensi dalam disiplin ilmu ini.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- 3. JALUR PENDIDIKAN FORMAL (THE ROADMAP) -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b-2 border-primary/20 pb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">alt_route</span>
                    <h3 class="text-2xl font-bold text-on-surface">Peta Jalur Pendidikan Formal</h3>
                </div>
                <p class="text-on-surface-variant">Berikut adalah beberapa alternatif jalur pendidikan dari tingkat menengah hingga pendidikan tinggi, diurutkan berdasarkan tingkat kecocokan profil Anda.</p>

                <!-- Roadmap Accordion Container -->
                <div class="space-y-4" id="roadmap-accordion">
                    
                    <!-- PATH 1: Utama (Expanded by default) -->
                    <div class="border border-outline-variant rounded-2xl bg-surface-container-lowest overflow-hidden shadow-sm">
                        @php
                            $topProf = collect($sortedTopN)->first();
                            $topProfName = $topProf['name'] ?? 'Bidang Terpilih';
                            $topProfScore = round($topProf['score'] ?? 0); // Score already in %
                        @endphp
                        <!-- Header Toggle -->
                        <button class="w-full text-left px-4 md:px-6 py-4 flex items-center justify-between bg-primary/5 hover:bg-primary/10 transition-colors" onclick="togglePath('path-1', 'icon-path-1')">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">1</div>
                                <div>
                                    <h4 class="font-bold text-base md:text-lg text-primary">Jalur Vokasi Terapan ({{ $topProfName }})</h4>
                                    <span class="text-xs md:text-sm text-on-surface-variant">Sangat Direkomendasikan (Kecocokan {{ $topProfScore }}%)</span>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-primary transition-transform duration-300 rotate-180" id="icon-path-1">expand_more</span>
                        </button>
                        
                        <!-- Content -->
                        <div id="path-1" class="p-4 md:p-8 border-t border-outline-variant block">
                            <!-- Responsive Roadmap Graphic -->
                            <div class="relative py-4 mb-8">
                                <!-- Desktop Connecting Line -->
                                <div class="hidden md:block absolute top-[2.5rem] left-[16.6%] right-[16.6%] h-1 bg-surface-variant z-0 rounded-full"></div>
                                <!-- Mobile Connecting Line -->
                                <div class="md:hidden absolute left-1/2 top-10 bottom-10 w-1 bg-surface-variant z-0 transform -translate-x-1/2 rounded-full"></div>
                                
                                <div class="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-0 relative z-10">
                                    <!-- Step 1 -->
                                    <div class="flex flex-col items-center group relative w-full md:w-1/3">
                                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-primary text-white flex items-center justify-center border-4 border-white shadow-lg mb-3 md:mb-4 transition-transform group-hover:scale-110">
                                            <span class="material-symbols-outlined text-2xl md:text-3xl">menu_book</span>
                                        </div>
                                        <div class="bg-surface-container-low border border-outline px-3 py-2 md:px-4 md:py-3 rounded-xl text-center shadow-sm w-[200px]">
                                            <span class="block text-[10px] md:text-xs text-on-surface-variant font-bold uppercase tracking-wider mb-1">Pendidikan Menengah</span>
                                            <span class="block text-sm md:text-base font-bold text-primary">Sekolah Menengah Terkait</span>
                                        </div>
                                    </div>
            
                                    <!-- Step 2 -->
                                    <div class="flex flex-col items-center group relative w-full md:w-1/3">
                                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-secondary text-white flex items-center justify-center border-4 border-white shadow-lg mb-3 md:mb-4 transition-transform group-hover:scale-110">
                                            <span class="material-symbols-outlined text-2xl md:text-3xl">account_balance</span>
                                        </div>
                                        <div class="bg-surface-container-low border border-outline px-3 py-2 md:px-4 md:py-3 rounded-xl text-center shadow-sm w-[200px]">
                                            <span class="block text-[10px] md:text-xs text-on-surface-variant font-bold uppercase tracking-wider mb-1">Pendidikan Tinggi</span>
                                            <span class="block text-sm md:text-base font-bold text-primary">{{ $topProfName }}</span>
                                            <div class="inline-flex items-center gap-1 bg-[#800000]/10 text-[#800000] px-2 py-0.5 rounded text-[10px] font-bold mt-2">
                                                <span class="material-symbols-outlined text-[12px]">school</span> Teknokrat: S1/D4 Unggulan
                                            </div>
                                        </div>
                                    </div>
            
                                    <!-- Step 3 -->
                                    <div class="flex flex-col items-center group relative w-full md:w-1/3">
                                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-tertiary text-white flex items-center justify-center border-4 border-white shadow-lg mb-3 md:mb-4 transition-transform group-hover:scale-110">
                                            <span class="material-symbols-outlined text-2xl md:text-3xl">workspace_premium</span>
                                        </div>
                                        <div class="bg-surface-container-low border border-outline px-3 py-2 md:px-4 md:py-3 rounded-xl text-center shadow-sm w-[200px]">
                                            <span class="block text-[10px] md:text-xs text-on-surface-variant font-bold uppercase tracking-wider mb-1">Proyeksi Karir</span>
                                            <span class="block text-sm md:text-base font-bold text-primary">Profesional {{ $topProfName }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Explanations -->
                            <div class="grid md:grid-cols-3 gap-4 md:gap-6 bg-surface-container-lowest">
                                <div class="bg-surface-container-low p-4 md:p-6 rounded-xl border border-surface-variant flex flex-col">
                                    <h4 class="text-base md:text-lg font-bold text-primary flex items-center gap-2 mb-2 md:mb-3">
                                        <span class="material-symbols-outlined text-lg md:text-xl bg-primary/10 p-1 rounded-md">looks_one</span> Fondasi Awal
                                    </h4>
                                    <p class="text-sm text-on-surface-variant leading-relaxed">
                                        Jalur ini dimulai dengan pemilihan sekolah menengah yang menitikberatkan pada keahlian praktis. Berdasarkan profil <strong>{{ $riasecLabels[$riasecCode] ?? '' }}</strong> Anda yang dominan, Anda akan merasa paling puas saat mempelajari hal-hal yang memiliki aplikasi langsung di dunia nyata.
                                    </p>
                                </div>
                                <div class="bg-surface-container-low p-4 md:p-6 rounded-xl border border-surface-variant flex flex-col">
                                    <h4 class="text-base md:text-lg font-bold text-primary flex items-center gap-2 mb-2 md:mb-3">
                                        <span class="material-symbols-outlined text-lg md:text-xl bg-primary/10 p-1 rounded-md">looks_two</span> Pendidikan Tinggi
                                    </h4>
                                    <p class="text-sm text-on-surface-variant leading-relaxed mb-4">
                                        Melanjutkan ke jenjang S1/D4 di bidang <strong>{{ $topProfName }}</strong> akan mengasah potensi Anda menjadi kompetensi profesional. Karakter <strong>{{ !empty($traitMatriks['high']) ? ($traitLabels[$traitMatriks['high'][0]] ?? '') : '' }}</strong> Anda menjamin presisi dan dedikasi dalam menempuh jalur ini hingga tuntas.
                                    </p>
                                    <div class="bg-white border-l-4 border-[#800000] p-3 rounded shadow-sm text-xs mt-auto">
                                        <strong class="text-[#800000] flex items-center gap-1 mb-1"><span class="material-symbols-outlined text-[14px]">assured_workload</span> Rekomendasi :</strong>
                                        <p class="text-on-surface-variant">Pilihlah program studi di Universitas Teknokrat Indonesia yang memiliki akreditasi Unggul untuk bidang ini.</p>
                                    </div>
                                </div>
                                <div class="bg-surface-container-low p-4 md:p-6 rounded-xl border border-surface-variant flex flex-col border-t-4 border-t-tertiary">
                                    <h4 class="text-base md:text-lg font-bold text-tertiary flex items-center gap-2 mb-2 md:mb-3">
                                        <span class="material-symbols-outlined text-lg md:text-xl bg-tertiary/10 p-1 rounded-md">looks_3</span> Masa Depan Karir
                                    </h4>
                                    <p class="text-sm text-on-surface-variant leading-relaxed mb-4">
                                        Sebagai <strong>Profesional {{ $topProfName }}</strong>, Anda akan bekerja di lingkungan yang selaras dengan nilai-nilai Anda. Kombinasi minat dan karakter Anda adalah modal utama untuk menjadi ahli yang diakui di industri ini.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PATH 2: Alternatif 1 (Collapsed) -->
                    @php
                        $alt1Prof = $sortedTopN[1] ?? null;
                        if($alt1Prof):
                        $alt1Name = $alt1Prof['name'] ?? 'Alternatif';
                        $alt1Score = round($alt1Prof['score'] ?? 0);
                    @endphp
                    <div class="border border-outline-variant rounded-2xl bg-surface-container-lowest overflow-hidden shadow-sm">
                        <!-- Header Toggle -->
                        <button class="w-full text-left px-4 md:px-6 py-4 flex items-center justify-between hover:bg-surface-container-low transition-colors" onclick="togglePath('path-2', 'icon-path-2')">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="bg-surface-variant text-on-surface-variant w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">2</div>
                                <div>
                                    <h4 class="font-bold text-base md:text-lg text-on-surface">Jalur Alternatif ({{ $alt1Name }})</h4>
                                    <span class="text-xs md:text-sm text-on-surface-variant">Alternatif Kuat (Kecocokan {{ $alt1Score }}%)</span>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-300" id="icon-path-2">expand_more</span>
                        </button>
                        
                        <!-- Content -->
                        <div id="path-2" class="p-4 md:p-8 border-t border-outline-variant hidden">
                            <!-- Responsive Roadmap Graphic -->
                            <div class="relative py-4 mb-8">
                                <div class="hidden md:block absolute top-[2.5rem] left-[16.6%] right-[16.6%] h-1 bg-surface-variant z-0 rounded-full"></div>
                                <div class="md:hidden absolute left-1/2 top-10 bottom-10 w-1 bg-surface-variant z-0 transform -translate-x-1/2 rounded-full"></div>
                                
                                <div class="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-0 relative z-10">
                                    <div class="flex flex-col items-center group relative w-full md:w-1/3">
                                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center border-4 border-white shadow-lg mb-3 md:mb-4">
                                            <span class="material-symbols-outlined text-2xl md:text-3xl">menu_book</span>
                                        </div>
                                        <div class="bg-surface-container-low border border-outline px-3 py-2 md:px-4 md:py-3 rounded-xl text-center shadow-sm w-[200px]">
                                            <span class="block text-[10px] md:text-xs text-on-surface-variant font-bold uppercase tracking-wider mb-1">Menengah Atas</span>
                                            <span class="block text-sm md:text-base font-bold text-on-surface">Sekolah Menengah Terkait</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center group relative w-full md:w-1/3">
                                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center border-4 border-white shadow-lg mb-3 md:mb-4">
                                            <span class="material-symbols-outlined text-2xl md:text-3xl">account_balance</span>
                                        </div>
                                        <div class="bg-surface-container-low border border-outline px-3 py-2 md:px-4 md:py-3 rounded-xl text-center shadow-sm w-[200px]">
                                            <span class="block text-[10px] md:text-xs text-on-surface-variant font-bold uppercase tracking-wider mb-1">Pendidikan Tinggi</span>
                                            <span class="block text-sm md:text-base font-bold text-on-surface">{{ $alt1Name }}</span>
                                            <div class="inline-flex items-center gap-1 bg-[#800000]/10 text-[#800000] px-2 py-0.5 rounded text-[10px] font-bold mt-2">
                                                <span class="material-symbols-outlined text-[12px]">school</span> UTI: S1/D4 Terkait
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center group relative w-full md:w-1/3">
                                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center border-4 border-white shadow-lg mb-3 md:mb-4">
                                            <span class="material-symbols-outlined text-2xl md:text-3xl">workspace_premium</span>
                                        </div>
                                        <div class="bg-surface-container-low border border-outline px-3 py-2 md:px-4 md:py-3 rounded-xl text-center shadow-sm w-[200px]">
                                            <span class="block text-[10px] md:text-xs text-on-surface-variant font-bold uppercase tracking-wider mb-1">Proyeksi Karir</span>
                                            <span class="block text-sm md:text-base font-bold text-on-surface">Profesional {{ $alt1Name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Explanations -->
                            <div class="grid md:grid-cols-3 gap-4 md:gap-6">
                                <div class="bg-surface-container-low p-4 md:p-6 rounded-xl border border-surface-variant flex flex-col">
                                    <h4 class="text-base md:text-lg font-bold text-on-surface flex items-center gap-2 mb-2">
                                        <span class="material-symbols-outlined text-lg bg-surface-variant/20 p-1 rounded-md">looks_one</span> Kenapa Memilih Jalur Ini?
                                    </h4>
                                    <p class="text-sm text-on-surface-variant leading-relaxed">
                                        Jalur ini direkomendasikan berdasarkan profil minat Anda yang menunjukkan kecocokan pada <strong>{{ $alt1Name }}</strong>. Kemampuan adaptasi Anda pada lingkungan <strong>{{ !empty($traitMatriks['high']) ? $traitLabels[$traitMatriks['high'][0]] ?? 'Karakter Dominan' : 'Karakter Dominan' }}</strong> menjadi landasan yang baik untuk sukses di bidang ini.
                                    </p>
                                </div>
                                <div class="bg-surface-container-low p-4 md:p-6 rounded-xl border border-surface-variant flex flex-col">
                                    <h4 class="text-base md:text-lg font-bold text-on-surface flex items-center gap-2 mb-2">
                                        <span class="material-symbols-outlined text-lg bg-surface-variant/20 p-1 rounded-md">looks_two</span> Arah Pendidikan Tinggi
                                    </h4>
                                    <p class="text-sm text-on-surface-variant leading-relaxed mb-4">
                                        Mengambil studi spesifik di bidang <strong>{{ $alt1Name }}</strong> akan membantu Anda mengasah kompetensi yang selaras dengan minat kedua terbesar Anda. Ini adalah langkah strategis untuk memperluas opsi karir Anda di masa depan.
                                    </p>
                                    <div class="bg-white border-l-4 border-[#800000] p-3 rounded shadow-sm text-xs mt-auto">
                                        <strong class="text-[#800000] flex items-center gap-1 mb-1"><span class="material-symbols-outlined text-[14px]">assured_workload</span> Teknokrat Rekomendasi Program studi :</strong>
                                        <p class="text-on-surface-variant">Pilihlah program studi relevan dengan akreditasi Unggul di Universitas Teknokrat Indonesia.</p>
                                    </div>
                                </div>
                                <div class="bg-surface-container-low p-4 md:p-6 rounded-xl border border-surface-variant flex flex-col border-t-4 border-t-tertiary">
                                    <h4 class="text-base md:text-lg font-bold text-tertiary flex items-center gap-2 mb-2">
                                        <span class="material-symbols-outlined text-lg bg-tertiary/10 p-1 rounded-md">looks_3</span> Proyeksi Karir: Profesional {{ $alt1Name }}
                                    </h4>
                                    <p class="text-sm text-on-surface-variant leading-relaxed mb-4">
                                        Kombinasi kompetensi dan minat Anda membuka peluang luas di industri ini. Sebagai seorang profesional di bidang ini, Anda akan memegang peran kunci yang menggabungkan kemampuan analitis dan adaptabilitas.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- PATH 3: Lintas Disiplin (Collapsed) -->
                    @php
                        $alt2Prof = $sortedTopN[2] ?? null;
                        if($alt2Prof):
                        $alt2Name = $alt2Prof['name'] ?? 'Lintas Disiplin';
                        $alt2Score = round($alt2Prof['score'] ?? 0);
                    @endphp
                    <div class="border border-outline-variant rounded-2xl bg-surface-container-lowest overflow-hidden shadow-sm">
                        <!-- Header Toggle -->
                        <button class="w-full text-left px-4 md:px-6 py-4 flex items-center justify-between hover:bg-surface-container-low transition-colors" onclick="togglePath('path-3', 'icon-path-3')">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="bg-surface-variant text-on-surface-variant w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">3</div>
                                <div>
                                    <h4 class="font-bold text-base md:text-lg text-on-surface">Jalur Alternatif Tambahan ({{ $alt2Name }})</h4>
                                    <span class="text-xs md:text-sm text-on-surface-variant">Lintas Disiplin (Kecocokan {{ $alt2Score }}%)</span>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-300" id="icon-path-3">expand_more</span>
                        </button>
                        
                        <!-- Content -->
                        <div id="path-3" class="p-4 md:p-8 border-t border-outline-variant hidden">
                             <!-- Responsive Roadmap Graphic -->
                             <div class="relative py-4 mb-8">
                                <div class="hidden md:block absolute top-[2.5rem] left-[16.6%] right-[16.6%] h-1 bg-surface-variant z-0 rounded-full"></div>
                                <div class="md:hidden absolute left-1/2 top-10 bottom-10 w-1 bg-surface-variant z-0 transform -translate-x-1/2 rounded-full"></div>
                                
                                <div class="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-0 relative z-10">
                                    <div class="flex flex-col items-center group relative w-full md:w-1/3">
                                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center border-4 border-white shadow-lg mb-3 md:mb-4">
                                            <span class="material-symbols-outlined text-2xl md:text-3xl">menu_book</span>
                                        </div>
                                        <div class="bg-surface-container-low border border-outline px-3 py-2 md:px-4 md:py-3 rounded-xl text-center shadow-sm w-[200px]">
                                            <span class="block text-[10px] md:text-xs text-on-surface-variant font-bold uppercase tracking-wider mb-1">Menengah Atas</span>
                                            <span class="block text-sm md:text-base font-bold text-on-surface">Sekolah Menengah Terkait</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center group relative w-full md:w-1/3">
                                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center border-4 border-white shadow-lg mb-3 md:mb-4">
                                            <span class="material-symbols-outlined text-2xl md:text-3xl">account_balance</span>
                                        </div>
                                        <div class="bg-surface-container-low border border-outline px-3 py-2 md:px-4 md:py-3 rounded-xl text-center shadow-sm w-[200px]">
                                            <span class="block text-[10px] md:text-xs text-on-surface-variant font-bold uppercase tracking-wider mb-1">Pendidikan Tinggi</span>
                                            <span class="block text-sm md:text-base font-bold text-on-surface">{{ $alt2Name }}</span>
                                            <div class="inline-flex items-center gap-1 bg-[#800000]/10 text-[#800000] px-2 py-0.5 rounded text-[10px] font-bold mt-2">
                                                <span class="material-symbols-outlined text-[12px]">school</span> UTI: S1/D4 Terkait
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center group relative w-full md:w-1/3">
                                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center border-4 border-white shadow-lg mb-3 md:mb-4">
                                            <span class="material-symbols-outlined text-2xl md:text-3xl">workspace_premium</span>
                                        </div>
                                        <div class="bg-surface-container-low border border-outline px-3 py-2 md:px-4 md:py-3 rounded-xl text-center shadow-sm w-[200px]">
                                            <span class="block text-[10px] md:text-xs text-on-surface-variant font-bold uppercase tracking-wider mb-1">Proyeksi Karir</span>
                                            <span class="block text-sm md:text-base font-bold text-on-surface">Profesional {{ $alt2Name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-3 gap-4 md:gap-6">
                                <div class="bg-surface-container-low p-4 md:p-6 rounded-xl border border-surface-variant flex flex-col">
                                    <h4 class="text-base md:text-lg font-bold text-on-surface flex items-center gap-2 mb-2">
                                        <span class="material-symbols-outlined text-lg bg-surface-variant/20 p-1 rounded-md">looks_one</span> Potensi Tersembunyi
                                    </h4>
                                    <p class="text-sm text-on-surface-variant leading-relaxed">
                                        Bidang <strong>{{ $alt2Name }}</strong> muncul sebagai rekomendasi kuat ketiga yang menunjukkan minat terpendam atau bakat sekunder Anda. Ini bisa menjadi profesi yang sangat Anda nikmati jika jalur utama tidak memungkinkan, mengingat skor ketertarikan Anda cukup signifikan.
                                    </p>
                                </div>
                                <div class="bg-surface-container-low p-4 md:p-6 rounded-xl border border-surface-variant flex flex-col">
                                    <h4 class="text-base md:text-lg font-bold text-on-surface flex items-center gap-2 mb-2">
                                        <span class="material-symbols-outlined text-lg bg-surface-variant/20 p-1 rounded-md">looks_two</span> Arah Pendidikan Tinggi
                                    </h4>
                                    <p class="text-sm text-on-surface-variant leading-relaxed mb-4">
                                        Pendidikan di bidang <strong>{{ $alt2Name }}</strong> bisa memperkuat portofolio Anda sebagai profesional yang "cross-functional" atau menguasai disiplin ilmu pelengkap dari minat utama Anda.
                                    </p>
                                    <div class="bg-white border-l-4 border-[#800000] p-3 rounded shadow-sm text-xs mt-auto">
                                        <strong class="text-[#800000] flex items-center gap-1 mb-1"><span class="material-symbols-outlined text-[14px]">assured_workload</span> Teknokrat Rekomendasi Program studi :</strong>
                                        <p class="text-on-surface-variant">Lengkapi minat Anda dengan prodi terkait yang inovatif dan terakreditasi baik.</p>
                                    </div>
                                </div>
                                <div class="bg-surface-container-low p-4 md:p-6 rounded-xl border border-surface-variant flex flex-col border-t-4 border-t-tertiary">
                                    <h4 class="text-base md:text-lg font-bold text-tertiary flex items-center gap-2 mb-2">
                                        <span class="material-symbols-outlined text-lg bg-tertiary/10 p-1 rounded-md">looks_3</span> Proyeksi Karir: Profesional {{ $alt2Name }}
                                    </h4>
                                    <p class="text-sm text-on-surface-variant leading-relaxed mb-4">
                                        Profesional di bidang ini membutuhkan kemampuan eksekusi yang konsisten serta pemikiran yang luas. Dengan perpaduan profil Anda, Anda memiliki kesempatan untuk berhasil dan berprestasi di industri terkait.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </section>

            <!-- 4. DAFTAR PERIKSA KESIAPAN (BERDASARKAN JALUR) -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b-2 border-primary/20 pb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">checklist</span>
                    <h3 class="text-2xl font-bold text-on-surface">Daftar Periksa Kesiapan</h3>
                </div>
                <p class="text-on-surface-variant">Pastikan Anda membekali diri dengan hal-hal berikut untuk sukses, disesuaikan dengan jalur yang Anda pilih.</p>

                <!-- Checklist Accordion Container -->
                <div class="space-y-4" id="checklist-accordion">
                    
                    <!-- CHECKLIST 1: Utama (Expanded by default) -->
                    <div class="border border-outline-variant rounded-2xl bg-surface-container-lowest overflow-hidden shadow-sm">
                        <button class="w-full text-left px-4 md:px-6 py-4 flex items-center justify-between bg-primary/5 hover:bg-primary/10 transition-colors" onclick="togglePath('checklist-1', 'icon-checklist-1')">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">1</div>
                                <div>
                                    <h4 class="font-bold text-base md:text-lg text-primary">Kesiapan: Jalur {{ $topProfName }}</h4>
                                    <span class="text-xs md:text-sm text-on-surface-variant">Fokus pada keahlian praktis dan teknikal bidang utama Anda</span>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-primary transition-transform duration-300 rotate-180" id="icon-checklist-1">expand_more</span>
                        </button>
                        
                        <div id="checklist-1" class="p-4 md:p-8 border-t border-outline-variant block bg-surface-container-lowest">
                            <div class="mb-6 p-4 bg-primary/5 rounded-xl border border-primary/20">
                                <p class="text-sm text-on-surface-variant leading-relaxed">
                                    <span class="material-symbols-outlined text-primary text-sm align-middle mr-1">info</span>
                                    @php
                                        // Build dynamic trait info from result data (using labels from controller)
                                        $topTraits = [];
                                        if (!empty($traitMatriks['high'])) {
                                            foreach (array_slice($traitMatriks['high'], 0, 2) as $tKey) {
                                                $tLabel = $traitLabels[$tKey] ?? $tKey;
                                                $tVal = isset($result->input_trait[$tKey]) ? round($result->input_trait[$tKey] * 100) : '?';
                                                $topTraits[] = "<strong>{$tLabel} ({$tVal}%)</strong>";
                                            }
                                        }
                                        $topRiasecItems = [];
                                        $riasecArr = $result->input_riasec ?? [];
                                        if (!empty($riasecArr)) {
                                            arsort($riasecArr);
                                            foreach (array_slice($riasecArr, 0, 2, true) as $rIdx => $rVal) {
                                                $rLabel = $riasecLabels[$rIdx] ?? $rIdx;
                                                $topRiasecItems[] = "<strong>{$rLabel} (" . round($rVal * 100) . "%)</strong>";
                                            }
                                        }
                                        $dynamicInfo = 'Daftar kesiapan ini disusun berdasarkan dominasi ';
                                        $allItems = array_merge($topRiasecItems, $topTraits);
                                        $dynamicInfo .= implode(', ', $allItems);
                                        $dynamicInfo .= ' pada profil Anda, yang paling sesuai dengan jalur <strong>' . ($topProfName ?? 'Pilihan') . '</strong>.';
                                    @endphp
                                    {!! $dynamicInfo !!}
                                </p>
                            </div>
                            <div class="grid md:grid-cols-3 gap-6">
                                <!-- Card 1: Mata Pelajaran -->
                                <div class="bg-surface-container-low border border-surface-variant rounded-xl p-6 shadow-sm hover:-translate-y-1 transition-transform">
                                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-2xl">menu_book</span>
                                    </div>
                                    <h4 class="font-bold text-on-surface mb-3">Mata Pelajaran Esensial</h4>
                                    <ul class="space-y-3">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-primary text-base mt-0.5">check_circle</span>
                                            <span><strong>Fisika Dasar & Elektronika</strong></span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-primary text-base mt-0.5">check_circle</span>
                                            <span>Matematika & Logika Dasar</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-primary text-base mt-0.5">check_circle</span>
                                            <span>Bahasa Inggris Teknikal</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-primary text-base mt-0.5">check_circle</span>
                                            <span>Agama & Pendidikan Karakter</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Card 2: Kompetensi -->
                                <div class="bg-surface-container-low border border-surface-variant rounded-xl p-6 shadow-sm hover:-translate-y-1 transition-transform">
                                    <div class="w-12 h-12 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-2xl">groups</span>
                                    </div>
                                    <h4 class="font-bold text-on-surface mb-3">Kompetensi yang Dibutuhkan</h4>
                                    <ul class="space-y-3 mb-4">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-secondary text-base mt-0.5">check_circle</span>
                                            <span>Kemampuan troubleshooting & konfigurasi sistem fisik</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-secondary text-base mt-0.5">check_circle</span>
                                            <span>Disiplin teknis & kedisiplinan operasional</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-secondary text-base mt-0.5">check_circle</span>
                                            <span>Kerja sama tim dalam penyelesaian proyek</span>
                                        </li>
                                    </ul>
                                    <p class="text-xs text-on-surface-variant mb-3 italic border-t border-surface-variant pt-3">Dapat ditingkatkan melalui proyek matakuliah & aktif di UKM:</p>
                                    <ul class="space-y-3">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-secondary text-base mt-0.5">arrow_right</span>
                                            <span><span class="bg-primary/10 text-primary px-1.5 py-0.5 rounded text-xs font-bold">UKM</span> <strong>Robotik Teknokrat:</strong> Mengembangkan logika kendali perangkat keras, mekanika, & pemahaman sistem IoT.</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-secondary text-base mt-0.5">arrow_right</span>
                                            <span><span class="bg-primary/10 text-primary px-1.5 py-0.5 rounded text-xs font-bold">UKM</span> <strong>Programming Teknokrat:</strong> Memperkuat dasar-dasar pemrograman dan integrasi sistem.</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Card 3: Sertifikasi -->
                                <div class="bg-surface-container-low border border-surface-variant rounded-xl p-6 shadow-sm hover:-translate-y-1 transition-transform border-l-4 border-l-primary">
                                    <div class="w-12 h-12 bg-tertiary/10 text-tertiary rounded-xl flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-2xl">verified</span>
                                    </div>
                                    <h4 class="font-bold text-on-surface mb-3">Sertifikasi & SKPI</h4>
                                    <ul class="space-y-3">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-tertiary text-base mt-0.5">check_circle</span>
                                            <span><strong>Cisco Network (CCNA) / Mikrotik</strong> — diwajibkan sebagai SKPI di UTI</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-tertiary text-base mt-0.5">check_circle</span>
                                            <span>CompTIA A+ / Network+</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-tertiary text-base mt-0.5">check_circle</span>
                                            <span>Sertifikasi IoT / Embedded Systems</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CHECKLIST 2: Alternatif 1 (Collapsed) -->
                    @if($alt1Prof)
                    <div class="border border-outline-variant rounded-2xl bg-surface-container-lowest overflow-hidden shadow-sm">
                        <button class="w-full text-left px-4 md:px-6 py-4 flex items-center justify-between hover:bg-surface-container-low transition-colors" onclick="togglePath('checklist-2', 'icon-checklist-2')">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="bg-surface-variant text-on-surface-variant w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">2</div>
                                <div>
                                    <h4 class="font-bold text-base md:text-lg text-on-surface">Kesiapan: Jalur {{ $alt1Name }}</h4>
                                    <span class="text-xs md:text-sm text-on-surface-variant">Fokus pada kompetensi dan keahlian spesifik alternatif pertama</span>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-300" id="icon-checklist-2">expand_more</span>
                        </button>
                        
                        <div id="checklist-2" class="p-4 md:p-8 border-t border-outline-variant hidden bg-surface-container-lowest">
                            <div class="mb-6 p-4 bg-surface-container rounded-xl border border-surface-variant">
                                <p class="text-sm text-on-surface-variant leading-relaxed">
                                    <span class="material-symbols-outlined text-on-surface-variant text-sm align-middle mr-1">info</span>
                                    Daftar kesiapan ini disusun berdasarkan kombinasi profil Anda, mempertimbangkan preferensi lingkungan yang mendukung bidang <strong>{{ $alt1Name }}</strong> secara maksimal.
                                </p>
                            </div>
                            <div class="grid md:grid-cols-3 gap-6">
                                <!-- Card 1: Mata Pelajaran -->
                                <div class="bg-surface-container-low border border-surface-variant rounded-xl p-6 shadow-sm hover:-translate-y-1 transition-transform">
                                    <div class="w-12 h-12 bg-surface-variant text-on-surface-variant rounded-xl flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-2xl">menu_book</span>
                                    </div>
                                    <h4 class="font-bold text-on-surface mb-3">Mata Pelajaran Esensial</h4>
                                    <ul class="space-y-3">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span><strong>Logika Pemrograman & Algoritma</strong></span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Matematika Diskrit & Statistika</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Bahasa Inggris & Komunikasi Ilmiah</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Kewirausahaan & Pengembangan Pribadi</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Card 2: Kompetensi -->
                                <div class="bg-surface-container-low border border-surface-variant rounded-xl p-6 shadow-sm hover:-translate-y-1 transition-transform">
                                    <div class="w-12 h-12 bg-surface-variant text-on-surface-variant rounded-xl flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-2xl">groups</span>
                                    </div>
                                    <h4 class="font-bold text-on-surface mb-3">Kompetensi yang Dibutuhkan</h4>
                                    <ul class="space-y-3 mb-4">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Penguasaan bahasa pemrograman tingkat tinggi</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Kemampuan berpikir kritis & analisis algoritma</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Kreativitas merancang arsitektur perangkat lunak</span>
                                        </li>
                                    </ul>
                                    <p class="text-xs text-on-surface-variant mb-3 italic border-t border-surface-variant pt-3">Dapat ditingkatkan melalui proyek matakuliah & aktif di UKM:</p>
                                    <ul class="space-y-3">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">arrow_right</span>
                                            <span><span class="bg-surface-variant text-on-surface-variant px-1.5 py-0.5 rounded text-xs font-bold">UKM</span> <strong>Programming Teknokrat:</strong> Meningkatkan penguasaan bahasa pemrograman, pemecahan masalah algoritma (CP), dan inovasi arsitektur software.</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">arrow_right</span>
                                            <span><span class="bg-surface-variant text-on-surface-variant px-1.5 py-0.5 rounded text-xs font-bold">UKM</span> <strong>Robotik Teknokrat:</strong> Mengaplikasikan logika kritis ke dalam sistem otonom dan pemrograman kecerdasan buatan (AI).</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Card 3: Sertifikasi -->
                                <div class="bg-surface-container-low border border-surface-variant rounded-xl p-6 shadow-sm hover:-translate-y-1 transition-transform border-l-4 border-l-primary">
                                    <div class="w-12 h-12 bg-surface-variant text-on-surface-variant rounded-xl flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-2xl">verified</span>
                                    </div>
                                    <h4 class="font-bold text-on-surface mb-3">Sertifikasi & SKPI</h4>
                                    <ul class="space-y-3">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span><strong>Sertifikasi Pengembang Software</strong> (diakui sebagai SKPI)</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Sertifikasi Data Analytics / AI Fundamentals</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- CHECKLIST 3: Lintas Disiplin (Collapsed) -->
                    @if($alt2Prof)
                    <div class="border border-outline-variant rounded-2xl bg-surface-container-lowest overflow-hidden shadow-sm">
                        <button class="w-full text-left px-4 md:px-6 py-4 flex items-center justify-between hover:bg-surface-container-low transition-colors" onclick="togglePath('checklist-3', 'icon-checklist-3')">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="bg-surface-variant text-on-surface-variant w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">3</div>
                                <div>
                                    <h4 class="font-bold text-base md:text-lg text-on-surface">Kesiapan: Jalur {{ $alt2Name }}</h4>
                                    <span class="text-xs md:text-sm text-on-surface-variant">Fokus pada kombinasi lintas keilmuan yang direkomendasikan</span>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-300" id="icon-checklist-3">expand_more</span>
                        </button>
                        
                        <div id="checklist-3" class="p-4 md:p-8 border-t border-outline-variant hidden bg-surface-container-lowest">
                            <div class="mb-6 p-4 bg-surface-container rounded-xl border border-surface-variant">
                                <p class="text-sm text-on-surface-variant leading-relaxed">
                                    <span class="material-symbols-outlined text-on-surface-variant text-sm align-middle mr-1">info</span>
                                    Daftar kesiapan ini dirancang agar Anda siap mengeksplorasi <strong>{{ $alt2Name }}</strong> sebagai alternatif karir menjanjikan, mengoptimalkan minat sekunder Anda.
                                </p>
                            </div>
                            <div class="grid md:grid-cols-3 gap-6">
                                <!-- Card 1: Mata Pelajaran -->
                                <div class="bg-surface-container-low border border-surface-variant rounded-xl p-6 shadow-sm hover:-translate-y-1 transition-transform">
                                    <div class="w-12 h-12 bg-surface-variant text-on-surface-variant rounded-xl flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-2xl">menu_book</span>
                                    </div>
                                    <h4 class="font-bold text-on-surface mb-3">Mata Pelajaran Esensial</h4>
                                    <ul class="space-y-3">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span><strong>Ekonomi & Manajemen Bisnis</strong></span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Business Intelligence & Analisis Data</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Kewirausahaan & Bahasa Indonesia Aktif</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Agama & Pengembangan Karakter</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Card 2: Kompetensi -->
                                <div class="bg-surface-container-low border border-surface-variant rounded-xl p-6 shadow-sm hover:-translate-y-1 transition-transform">
                                    <div class="w-12 h-12 bg-surface-variant text-on-surface-variant rounded-xl flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-2xl">groups</span>
                                    </div>
                                    <h4 class="font-bold text-on-surface mb-3">Kompetensi yang Dibutuhkan</h4>
                                    <ul class="space-y-3 mb-4">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Komunikasi organisasional & public speaking</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Manajemen proyek, waktu, & kepemimpinan tim</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Analisis proses bisnis & pemecahan masalah</span>
                                        </li>
                                    </ul>
                                    <p class="text-xs text-on-surface-variant mb-3 italic border-t border-surface-variant pt-3">Dapat ditingkatkan melalui proyek matakuliah & aktif di UKM:</p>
                                    <ul class="space-y-3">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">arrow_right</span>
                                            <span><span class="bg-surface-variant text-on-surface-variant px-1.5 py-0.5 rounded text-xs font-bold">UKM</span> <strong>Entrepreneur Teknokrat:</strong> Melatih pola pikir bisnis, manajemen produk, dan perancangan startup digital.</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">arrow_right</span>
                                            <span><span class="bg-surface-variant text-on-surface-variant px-1.5 py-0.5 rounded text-xs font-bold">UKM</span> <strong>Duta Teknokrat:</strong> Membangun karisma kepemimpinan, teknik presentasi bisnis, dan jejaring relasi.</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">arrow_right</span>
                                            <span><span class="bg-surface-variant text-on-surface-variant px-1.5 py-0.5 rounded text-xs font-bold">UKM</span> <strong>Teknokrat English Club:</strong> Mengembangkan kemampuan public speaking tingkat internasional dan literasi bisnis global.</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Card 3: Sertifikasi -->
                                <div class="bg-surface-container-low border border-surface-variant rounded-xl p-6 shadow-sm hover:-translate-y-1 transition-transform border-l-4 border-l-primary">
                                    <div class="w-12 h-12 bg-surface-variant text-on-surface-variant rounded-xl flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-2xl">verified</span>
                                    </div>
                                    <h4 class="font-bold text-on-surface mb-3">Sertifikasi & SKPI</h4>
                                    <ul class="space-y-3">
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span><strong>Sertifikasi Manajemen Proyek / ITIL</strong> (sebagai SKPI pendamping ijazah)</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-on-surface-variant text-base mt-0.5">check_circle</span>
                                            <span>Sertifikasi Agile / Scrum Fundamental</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </section>
        </main>

        <footer class="py-6 text-center border-t border-[#800000] mt-auto bg-[#800000] text-white">
            <p class="text-sm text-white/90">&copy; 2026 Shiro-Asesmen by Rakhmat Dedi G &amp; Team</p>
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('hidden');
            overlay.classList.toggle('hidden');
        }

        function performReview() {
            document.getElementById('modalReview').classList.remove('hidden');
            document.getElementById('modalReview').classList.add('flex');
        }

        function closeReviewModal() {
            document.getElementById('modalReview').classList.add('hidden');
            document.getElementById('modalReview').classList.remove('flex');
        }

        function setRating(questionId, rating) {
            const container = document.getElementById(questionId);
            const stars = container.querySelectorAll('.material-symbols-outlined');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('text-[#FFD700]');
                    star.classList.remove('text-surface-variant');
                } else {
                    star.classList.remove('text-[#FFD700]');
                    star.classList.add('text-surface-variant');
                }
            });
        }

        function submitReview() {
            const btnSubmit = document.getElementById('btnSubmitReview');
            const btnReview = document.getElementById('btnReview');
            const btnExport = document.getElementById('btnExport');
            const lockIcon = document.getElementById('lockIcon');

            btnSubmit.innerHTML = '<span class="material-symbols-outlined animate-spin text-[18px]">sync</span> Mengirim...';
            btnSubmit.disabled = true;
            
            setTimeout(() => {
                btnReview.innerHTML = '<span class="material-symbols-outlined text-[18px]">check_circle</span> Review Selesai';
                btnReview.classList.remove('bg-[#FFD700]', 'text-[#800000]', 'hover:bg-white');
                btnReview.classList.add('bg-green-600', 'text-white', 'cursor-default');
                btnReview.disabled = true;
                
                // Unlock Export
                btnExport.setAttribute('data-locked', 'false');
                btnExport.classList.remove('opacity-60', 'cursor-not-allowed', 'shadow-none');
                btnExport.classList.add('shadow-md', 'hover:bg-[#FFD700]', 'hover:border-[#FFD700]');
                lockIcon.innerHTML = 'check';
                lockIcon.classList.add('text-green-600');

                closeReviewModal();
                alert('Terima kasih! Review Anda telah tersimpan. Sekarang Anda dapat membagikan hasil asesmen.');
            }, 1500);
        }

        function exportPDF() {
            closeExportModal();
            showProcessing('Membuat laporan PDF lengkap dari server...', () => {
                window.location.href = "{{ route('laporan-lengkap.pdf') }}";
            });
        }

        function exportEmail() {
            const email = prompt('Masukkan alamat email tujuan:', 'user@example.com');
            if (email) {
                showProcessing('Meng-generate laporan dan mengirim ke email...', () => {
                    alert('Laporan PDF telah berhasil di-generate dan dikirim ke ' + email);
                });
            }
        }

        function exportWA() {
            showProcessing('Meng-generate ringkasan laporan...', () => {
                const text = encodeURIComponent('Halo! Saya ingin membagikan hasil asesmen ShiroAsesmen saya. Hasilnya sangat menarik! Cek di sini untuk melihat profil karakter dan rekomendasi karir saya.');
                window.open(`https://wa.me/?text=${text}`, '_blank');
            });
        }

        function showProcessing(message, callback) {
            const modal = document.getElementById('processingModal');
            const msgEl = document.getElementById('processingMessage');
            const progress = document.getElementById('processingProgress');
            
            msgEl.innerText = message;
            progress.style.width = '0%';
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            let p = 0;
            const interval = setInterval(() => {
                p += Math.random() * 30;
                if (p >= 100) {
                    p = 100;
                    clearInterval(interval);
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        if (callback) callback();
                    }, 500);
                }
                progress.style.width = p + '%';
            }, 400);
        }

        function openExportModal() {
            const btnExport = document.getElementById('btnExport');
            const btnReview = document.getElementById('btnReview');
            
            if (btnExport.getAttribute('data-locked') === 'true') {
                if (!btnReview.disabled) {
                    alert('Anda harus mengisi review terlebih dahulu sebelum membagikan hasil!');
                    performReview();
                }
                return;
            }
            document.getElementById('exportModal').classList.remove('hidden');
            document.getElementById('exportModal').classList.add('flex');
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.add('hidden');
            document.getElementById('exportModal').classList.remove('flex');
        }

        function togglePath(pathId, iconId) {
            const content = document.getElementById(pathId);
            const icon = document.getElementById(iconId);
            
            // Toggle visibility of the content
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                content.classList.add('block');
                icon.classList.add('rotate-180');
            } else {
                content.classList.remove('block');
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
    </script>
    <!-- EXPORT MODAL -->
    <div id="exportModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeExportModal()"></div>
        <div class="bg-white rounded-3xl w-full max-w-lg relative z-10 overflow-hidden shadow-2xl">
            <div class="p-8 border-b border-surface-variant flex justify-between items-start bg-primary/5">
                <div>
                    <h3 class="text-2xl font-black text-primary tracking-tight uppercase italic">Bagikan Hasil</h3>
                    <p class="text-sm text-on-surface-variant">Pilih format pengiriman laporan Anda</p>
                </div>
                <button onclick="closeExportModal()" class="p-2 hover:bg-primary/10 rounded-full transition-colors text-primary">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-8 space-y-4">
                <!-- PDF Option -->
                <button onclick="exportPDF()" class="w-full group flex items-center gap-4 p-4 rounded-2xl border border-surface-variant hover:border-primary hover:bg-primary/5 transition-all text-left">
                    <div class="p-3 rounded-xl bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[28px]">picture_as_pdf</span>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-on-surface">Cetak PDF</div>
                        <div class="text-xs text-on-surface-variant">Laporan lengkap format A4 siap cetak</div>
                    </div>
                    <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary">chevron_right</span>
                </button>

                <!-- Kembali ke Halaman Login -->
                <a href="{{ route('login') }}" class="w-full group flex items-center gap-4 p-4 rounded-2xl border border-surface-variant hover:border-amber-500 hover:bg-amber-50 transition-all text-left mt-2">
                    <div class="p-3 rounded-xl bg-amber-100 text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[28px]">home</span>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-on-surface">Kembali ke Halaman Awal</div>
                        <div class="text-xs text-on-surface-variant">Asesmen baru atau lihat riwayat</div>
                    </div>
                    <span class="material-symbols-outlined text-on-surface-variant group-hover:text-amber-500">chevron_right</span>
                </a>

                <!-- Email Option -->
                <button onclick="exportEmail()" class="w-full group flex items-center gap-4 p-4 rounded-2xl border border-surface-variant hover:border-primary hover:bg-primary/5 transition-all text-left">
                    <div class="p-3 rounded-xl bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[28px]">mail</span>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-on-surface">Kirim Email</div>
                        <div class="text-xs text-on-surface-variant">Kirim ke alamat email terdaftar/tujuan</div>
                    </div>
                    <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary">chevron_right</span>
                </button>
                
                <!-- WA Option -->
                <button onclick="exportWA()" class="w-full group flex items-center gap-4 p-4 rounded-2xl border border-surface-variant hover:border-primary hover:bg-primary/5 transition-all text-left">
                    <div class="p-3 rounded-xl bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[28px]">chat</span>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-on-surface">Berbagi WhatsApp</div>
                        <div class="text-xs text-on-surface-variant">Ringkasan hasil via chat interaktif</div>
                    </div>
                    <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary">chevron_right</span>
                </button>
            </div>
            <div class="p-6 bg-surface-container-low text-center">
                <p class="text-[10px] text-on-surface-variant uppercase font-bold tracking-widest">&copy; 2026 ShiroAsesmen - Laporan Hasil Akademik & Karakter</p>
            </div>
        </div>
    </div>
    <!-- Scroll-to-Top Button -->
    <button id="scrollToTopBtn" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="fixed bottom-8 right-8 w-12 h-12 bg-surface-container-lowest border border-surface-variant text-primary rounded-full shadow-[0px_4px_20px_rgba(0,0,0,0.1)] flex items-center justify-center hover:bg-surface-container hover:text-primary-container transition-colors z-50">
        <span class="material-symbols-outlined">arrow_upward</span>
    </button>

    <!-- MODAL REVIEW (Style DS2) -->
    <div id="modalReview" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeReviewModal()"></div>
        <div class="glass-card w-full max-w-2xl rounded-[2.5rem] p-10 relative z-10 overflow-hidden shadow-2xl bg-white">
            <div class="absolute top-0 left-0 w-full h-2 bg-[#800000]"></div>
            <button onclick="closeReviewModal()" class="absolute top-6 right-6 text-on-surface-variant hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
            
            <h3 class="font-headline-lg text-headline-lg text-[#800000] mb-2 text-center">Ulasan Asesmen</h3>
            <p class="font-body-md text-body-md text-on-surface-variant text-center mb-10">Bantu kami meningkatkan kualitas sistem dengan memberikan penilaian Anda.</p>
            
            <form class="space-y-6">
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-4 bg-surface rounded-xl border border-surface-variant">
                        <span class="font-body-md text-on-surface mb-2 md:mb-0">Seberapa sesuai hasil ini dengan diri Anda?</span>
                        <div class="flex space-x-2 text-surface-variant" id="ratingAkurasi">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="material-symbols-outlined cursor-pointer hover:text-[#FFD700] transition-colors" onclick="setRating('ratingAkurasi', {{ $i }})">star</span>
                            @endfor
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-4 bg-surface rounded-xl border border-surface-variant">
                        <span class="font-body-md text-on-surface mb-2 md:mb-0">Seberapa bermanfaat tes asesmen ini?</span>
                        <div class="flex space-x-2 text-surface-variant" id="ratingManfaat">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="material-symbols-outlined cursor-pointer hover:text-[#FFD700] transition-colors" onclick="setRating('ratingManfaat', {{ $i }})">star</span>
                            @endfor
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-4 bg-surface rounded-xl border border-surface-variant">
                        <span class="font-body-md text-on-surface mb-2 md:mb-0">Seberapa mudah penggunaan aplikasi ini?</span>
                        <div class="flex space-x-2 text-surface-variant" id="ratingKemudahan">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="material-symbols-outlined cursor-pointer hover:text-[#FFD700] transition-colors" onclick="setRating('ratingKemudahan', {{ $i }})">star</span>
                            @endfor
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="feedback">Saran dan Kritik</label>
                    <textarea class="w-full bg-surface border border-surface-variant rounded-xl p-4 font-body-md focus:outline-none focus:ring-2 focus:ring-[#800000] focus:border-transparent transition-all" id="feedback" placeholder="Tuliskan pengalaman Anda..." rows="4"></textarea>
                </div>
                
                <div class="flex justify-end">
                    <button id="btnSubmitReview" onclick="submitReview()" class="px-6 py-3 bg-[#800000] text-white rounded-xl font-medium hover:bg-[#570000] transition-colors flex items-center space-x-2 shadow-md" type="button">
                        <span>Kirim Umpan Balik</span>
                        <span class="material-symbols-outlined text-[#FFD700]">send</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- PROCESSING MODAL -->
    <div id="processingModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-[#800000]/20 backdrop-blur-md"></div>
        <div class="bg-white rounded-3xl w-full max-sm relative z-10 p-8 shadow-2xl text-center">
            <div class="mb-6 relative">
                <div class="w-20 h-20 border-4 border-[#800000]/10 border-t-[#800000] rounded-full animate-spin mx-auto"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[#800000]">description</span>
                </div>
            </div>
            <h4 id="processingMessage" class="text-lg font-bold text-[#800000] mb-2">Sedang memproses...</h4>
            <p class="text-xs text-on-surface-variant mb-6">Harap jangan menutup halaman ini</p>
            <div class="w-full bg-surface-variant h-1.5 rounded-full overflow-hidden">
                <div id="processingProgress" class="bg-[#FFD700] h-full transition-all duration-300" style="width: 0%"></div>
            </div>
        </div>
    </div>
</body>
</html>
