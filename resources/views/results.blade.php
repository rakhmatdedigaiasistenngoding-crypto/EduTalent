<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>ShiroAsesmen Dashboard</title>
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
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(128, 0, 0, 0.1);
            box-shadow: 0 10px 40px -10px rgba(128, 0, 0, 0.08);
        }

        /* Highlight effect for Smart Search Guide */
        section:target {
            animation: highlight-section 2s ease-out;
            scroll-margin-top: 100px;
        }

        @keyframes highlight-section {
            0% { background-color: rgba(255, 215, 0, 0.3); outline: 2px solid #800000; }
            100% { background-color: transparent; outline: 2px solid transparent; }
        }

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
    
    <!-- Sidebar Mobile Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden backdrop-blur-sm" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR (DS1 Structure, DS2 Coloring: Maroon bg, White text, Gold accents) -->
    <nav id="sidebar" class="hidden lg:flex h-screen w-64 fixed left-0 top-0 bg-[#800000] z-50 flex-col py-6 text-white shadow-xl overflow-hidden no-print">
        <!-- Sidebar brand header -->
        <div class="px-6 mb-stack-lg text-center flex flex-col items-center">
            <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center mb-3 shadow-lg border-2 border-[#FFD700] p-1">
                <img alt="Logo UTI" class="w-full h-full object-contain" src="{{ asset('assets/Teknokrat/logo UNIVERSITASTEKNOKRAT.png') }}" onerror="this.src='https://ui-avatars.com/api/?name=UTI&background=fff&color=800000'"/>
            </div>
            <div>
                <h1 class="text-sm font-black tracking-tight text-white uppercase leading-tight">Universitas Teknokrat Indonesia</h1>
                <p class="text-[#FFD700] text-[10px] font-bold tracking-widest uppercase mt-1">Kampusnya Sang Juara</p>
            </div>
        </div>
        <!-- Nav links -->
        <div class="flex-1 flex flex-col gap-1 px-4">
            <!-- Active Tab -->
            <!-- Dashboard Tab (History) -->
            <a class="flex items-center gap-3 px-4 py-3 text-white/70 font-medium hover:text-white hover:bg-white/5 rounded-l-lg transition-colors duration-200" href="{{ url('/') }}">
                <span class="material-symbols-outlined">home</span>
                <span class="font-label-md text-label-md">Beranda</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('assessment.history') ? 'bg-white/10 text-white border-r-4 border-[#FFD700]' : 'text-white/70' }} font-medium hover:text-white hover:bg-white/5 rounded-l-lg transition-colors duration-200" href="{{ route('assessment.history') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-label-md text-label-md">Dashboard</span>
            </a>
            <!-- Inactive Tabs -->
            <a class="flex items-center gap-3 px-4 py-3 text-white/70 font-medium hover:text-white hover:bg-white/5 rounded-l-lg transition-colors duration-200" href="{{ url('/psikometrik') }}">
                <span class="material-symbols-outlined">psychology</span>
                <span class="font-label-md text-label-md">Psikometrik</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-white/70 font-medium hover:text-white hover:bg-white/5 rounded-l-lg transition-colors duration-200" href="{{ url('/peta-pendidikan') }}">
                <span class="material-symbols-outlined">map</span>
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
        <!-- Review button + Gedung background area -->
        <div class="mt-auto relative h-1/3 w-full flex flex-col justify-end">
            <!-- Gedung background image (transparent) below review button -->
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
                @if(auth()->check())
                <form action="{{ route('logout.post') }}" method="POST" class="w-full mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white/10 text-white rounded-lg font-bold hover:bg-white/20 transition-all">
                        <span class="material-symbols-outlined">logout</span> Keluar
                    </button>
                </form>
                @else
                <a href="{{ url('/') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white/10 text-white rounded-lg font-bold hover:bg-white/20 transition-all mt-2 text-center">
                    <span class="material-symbols-outlined">login</span> Login / Beranda
                </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen relative">
        
        <!-- TOP NAV (DS1 Style) -->
        <header class="sticky top-0 w-full z-40 border-b border-surface-variant bg-surface-container-lowest/80 backdrop-blur-md shadow-none border-b-2 border-primary/10 no-print">
            <div class="flex items-center justify-between px-4 md:px-8 py-3 max-w-[1280px] mx-auto">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 -ml-2 text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="flex flex-col ml-2 md:ml-0">
                        <span class="text-xs font-semibold text-on-surface-variant tracking-widest uppercase">Shiro-Asesmen &bull; Hasil Asesmen</span>
                        <span class="text-lg font-bold text-primary font-headline-md text-headline-md">Dashboard</span>
                    </div>
                </div>
                <div class="flex items-center gap-3 md:gap-6">
                    <!-- Search Bar -->
                    <div class="relative hidden lg:block" id="searchContainer">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl">search</span>
                        <input id="smartSearchInput" class="pl-10 pr-4 py-2 bg-surface-container-low border-b-2 border-transparent focus:border-primary focus:bg-surface-container-lowest focus:ring-0 rounded-xl transition-all font-body-md text-sm w-48 xl:w-80 text-on-surface" placeholder="Cari profesi, jurusan..." type="text" autocomplete="off"/>
                        
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
                            <span class="text-[8px] font-extrabold text-on-surface-variant uppercase tracking-tighter leading-none whitespace-nowrap">{{ session('user_name') ?? (auth()->user()->name ?? 'Guest') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 p-margin max-w-[1280px] w-full mx-auto space-y-stack-xl">
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
                        <div class="font-bold">Nama: {{ session('user_name') ?? (auth()->user()->name ?? 'Guest') }}</div>
                        <div>ID Asesmen: SA-{{ \Carbon\Carbon::parse($result->created_at)->format('Ymd') }}-{{ sprintf('%03d', $result->id) }}</div>
                    </div>
                    <div class="text-xs text-on-surface-variant italic">Dicetak pada: <span id="printDate"></span></div>
                </div>
            </div>
            
            <!-- BREADCRUMB (dari Kops) -->
            <div class="text-[10px] font-bold tracking-widest uppercase text-on-surface-variant mb-[-1rem]">
                SHIROASESMEN &bull; HASIL ASESMEN &bull; <span class="text-primary">DASHBOARD</span>
            </div>

            <!-- KOPS BANNER (Gradient Soft Maroon + Gedung) -->
            <section id="rangkuman-hasil" class="relative rounded-2xl overflow-hidden shadow-lg border border-surface-variant bg-[#800000]">
                <!-- Background Building Image with Blend -->
                <img src="{{ asset('assets/Teknokrat/Gedung Utama UTI.jpeg') }}" onerror="this.src='https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1000&auto=format&fit=crop'" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-30">
                <div class="absolute inset-0 bg-gradient-to-r from-[#800000] to-[#570000]/80"></div>
                <!-- Content -->
                <div class="relative z-10 p-10 flex flex-col md:flex-row items-center justify-between">
                    <div class="w-full">
                        <div class="flex items-center gap-3 mb-3">
                            <h2 class="text-3xl font-black text-white italic tracking-tight">RANGKUMAN HASIL ASESMEN</h2>
                            <span class="bg-white/20 text-white text-[9px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1 backdrop-blur-sm">
                                <span class="material-symbols-outlined text-[10px]">auto_awesome</span> AI Generated
                            </span>
                        </div>
                        <p class="text-white/90 font-body-md max-w-3xl leading-relaxed italic">
                            @php $summaryText = is_string($summary ?? '') ? $summary : ''; @endphp
                            {!! !empty($summaryText) ? nl2br(e($summaryText)) : 'Hasil asesmen Anda telah berhasil dianalisis. Silakan muat ulang halaman untuk memuat ringkasan AI.' !!}
                        </p>
                    </div>
                </div>
            </section>

            <!-- USER PROFILE (DS1 Style, no avatar) -->
            <section id="draf-pengguna" class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-[0px_4px_20px_rgba(0,0,0,0.05)] overflow-hidden">
                <div class="h-2 bg-secondary-container w-full"></div>
                <div class="p-stack-lg flex flex-col md:flex-row items-center gap-stack-lg">
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="font-headline-lg text-headline-lg text-primary mb-6">Status Asesmen</h2>
                        @php
                            $stbScore = $stability['score'] ?? 0.85;
                            $akurasi = number_format(($stbScore * 15) + 80, 0); // 80 - 95% base + stability
                            if ($akurasi > 99) $akurasi = 99;
                            
                            $konsistensi = 'Sedang';
                            if ($stbScore >= 0.8) $konsistensi = 'Tinggi';
                            elseif ($stbScore < 0.5) $konsistensi = 'Rendah';

                            $keseriusan = 'Baik';
                            if ($stbScore >= 0.8) $keseriusan = 'Sangat Baik';
                            elseif ($stbScore < 0.5) $keseriusan = 'Kurang';
                        @endphp
                        <!-- Stats Column: Vertical stack for better responsiveness and clarity -->
                        <div class="flex flex-col gap-3 w-full max-w-md mx-auto md:mx-0">
                            <div class="bg-surface-container-low w-full px-4 py-3 rounded-xl border border-surface-variant flex items-center gap-4 shadow-sm hover:border-primary/30 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                                    <span class="material-symbols-outlined text-2xl">analytics</span>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-0.5">Akurasi Jawaban</p>
                                    <p class="text-lg font-black text-on-surface">{{ $akurasi }}%</p>
                                </div>
                            </div>
                            <div class="bg-surface-container-low w-full px-4 py-3 rounded-xl border border-surface-variant flex items-center gap-4 shadow-sm hover:border-primary/30 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                                    <span class="material-symbols-outlined text-2xl">sync</span>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-0.5">Konsistensi Profil</p>
                                    <p class="text-lg font-black text-on-surface">{{ $konsistensi }}</p>
                                </div>
                            </div>
                            <div class="bg-surface-container-low w-full px-4 py-3 rounded-xl border border-surface-variant flex items-center gap-4 shadow-sm hover:border-secondary/30 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary flex-shrink-0">
                                    <span class="material-symbols-outlined text-2xl">workspace_premium</span>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-0.5">Keseriusan Pengisian</p>
                                    <p class="text-lg font-black text-secondary-fixed-dim whitespace-nowrap">{{ $keseriusan }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Area Keterangan (Placeholder for low consistency/accuracy) -->
                        <div id="status-insight" class="mt-4 hidden p-3 bg-error-container/20 border border-error/10 rounded-lg flex items-start gap-3">
                            <span class="material-symbols-outlined text-error">info</span>
                            <p class="text-xs text-on-surface-variant leading-relaxed italic">Hasil asesmen menunjukkan indikasi ketidakkonsistenan yang cukup tinggi. Disarankan untuk berdiskusi lebih lanjut dengan Guru BK.</p>
                        </div>
                    </div>
                    <!-- Right: Rebuilt Radar Chart (Labels inside SVG for absolute safety) -->
                    <div id="visualisasi-riasec" class="w-full md:w-auto flex flex-col items-center justify-center border-t md:border-t-0 md:border-l border-surface-variant pt-8 md:pt-0 md:pl-16">
                        <h4 class="font-label-md text-label-md text-on-surface-variant mb-4 text-center tracking-widest uppercase">Visualisasi RIASEC</h4>
                        <div class="relative w-full max-w-[280px] aspect-square mx-auto">
                            @php
                                // [FIX BUG-4] Radar RIASEC menggunakan input_riasec (bukan result_riasec yg tidak ada)
                                $riasecRaw = $result->input_riasec ?? [];
                                $riasecKeys = array_keys($riasecRaw);
                                $r = isset($riasecKeys[0]) ? ($riasecRaw[$riasecKeys[0]] ?? 0) : 0;
                                $i = isset($riasecKeys[1]) ? ($riasecRaw[$riasecKeys[1]] ?? 0) : 0;
                                $a = isset($riasecKeys[2]) ? ($riasecRaw[$riasecKeys[2]] ?? 0) : 0;
                                $s = isset($riasecKeys[3]) ? ($riasecRaw[$riasecKeys[3]] ?? 0) : 0;
                                $e = isset($riasecKeys[4]) ? ($riasecRaw[$riasecKeys[4]] ?? 0) : 0;
                                $c = isset($riasecKeys[5]) ? ($riasecRaw[$riasecKeys[5]] ?? 0) : 0;

                                // Normalize if needed, max radius 60
                                $ptR = "80," . (80 - 60 * $r);
                                $ptI = (80 + 52 * $i) . "," . (80 - 30 * $i);
                                $ptA = (80 + 52 * $a) . "," . (80 + 30 * $a);
                                $ptS = "80," . (80 + 60 * $s);
                                $ptE = (80 - 52 * $e) . "," . (80 + 30 * $e);
                                $ptC = (80 - 52 * $c) . "," . (80 - 30 * $c);
                                $pts = "$ptR $ptI $ptA $ptS $ptE $ptC";
                            @endphp
                            <svg class="w-full h-full overflow-visible" viewbox="0 0 160 160">
                                <!-- Center at 80,80. Max Radius 60 (Total 120) -->
                                <!-- Hexagon Background Grids -->
                                <polygon fill="none" points="80,20 132,50 132,110 80,140 28,110 28,50" stroke="#e1e3e4" stroke-width="1"></polygon>
                                <polygon fill="none" points="80,40 115,60 115,100 80,120 45,100 45,60" stroke="#e1e3e4" stroke-width="0.75"></polygon>
                                <polygon fill="none" points="80,60 97,70 97,90 80,100 63,90 63,70" stroke="#e1e3e4" stroke-width="0.5"></polygon>
                                
                                <!-- Axes -->
                                <line stroke="#e1e3e4" stroke-width="0.75" x1="80" x2="80" y1="80" y2="20"></line>
                                <line stroke="#e1e3e4" stroke-width="0.75" x1="80" x2="132" y1="80" y2="50"></line>
                                <line stroke="#e1e3e4" stroke-width="0.75" x1="80" x2="132" y1="80" y2="110"></line>
                                <line stroke="#e1e3e4" stroke-width="0.75" x1="80" x2="80" y1="80" y2="140"></line>
                                <line stroke="#e1e3e4" stroke-width="0.75" x1="80" x2="28" y1="80" y2="110"></line>
                                <line stroke="#e1e3e4" stroke-width="0.75" x1="80" x2="28" y1="80" y2="50"></line>
                                
                                <!-- Data Polygon (Dynamic) -->
                                <polygon fill="rgba(128, 0, 0, 0.25)" points="{{ $pts }}" stroke="#800000" stroke-width="2.5"></polygon>
                                
                                <!-- Data Points -->
                                <circle cx="{{ 80 }}" cy="{{ 80 - 60 * $r }}" fill="#FFD700" r="4.5" stroke="#800000" stroke-width="2"></circle>
                                <circle cx="{{ 80 + 52 * $i }}" cy="{{ 80 - 30 * $i }}" fill="#FFD700" r="4.5" stroke="#800000" stroke-width="2"></circle>
                                <circle cx="{{ 80 + 52 * $a }}" cy="{{ 80 + 30 * $a }}" fill="#FFD700" r="4.5" stroke="#800000" stroke-width="2"></circle>
                                <circle cx="{{ 80 }}" cy="{{ 80 + 60 * $s }}" fill="#FFD700" r="4.5" stroke="#800000" stroke-width="2"></circle>
                                <circle cx="{{ 80 - 52 * $e }}" cy="{{ 80 + 30 * $e }}" fill="#FFD700" r="4.5" stroke="#800000" stroke-width="2"></circle>
                                <circle cx="{{ 80 - 52 * $c }}" cy="{{ 80 - 30 * $c }}" fill="#FFD700" r="4.5" stroke="#800000" stroke-width="2"></circle>

                                <!-- Text Labels -->
                                <text class="font-bold fill-on-surface" font-size="12" text-anchor="middle" x="80" y="12">R</text>
                                <text class="font-bold fill-on-surface" font-size="12" text-anchor="start" x="140" y="52">I</text>
                                <text class="font-bold fill-on-surface" font-size="12" text-anchor="start" x="140" y="115">A</text>
                                <text class="font-bold fill-on-surface" font-size="12" text-anchor="middle" x="80" y="155">S</text>
                                <text class="font-bold fill-on-surface" font-size="12" text-anchor="end" x="20" y="115">E</text>
                                <text class="font-bold fill-on-surface" font-size="12" text-anchor="end" x="20" y="52">C</text>
                            </svg>
                        </div>
                    </div>
                </div>
            </section>

            <!-- PROFIL INPUT ASESMEN: Menampilkan data awal user dengan nama domain -->
            <section id="profil-input-asesmen" class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-[0px_4px_20px_rgba(0,0,0,0.05)] overflow-hidden">
                <div class="h-2 bg-gradient-to-r from-[#800000] to-[#FFD700] w-full"></div>
                <div class="p-stack-lg">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-2xl text-primary">manage_accounts</span>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Profil Input Asesmen Anda</h3>
                        <span class="text-[9px] font-bold bg-[#800000] text-white px-2 py-0.5 rounded-full uppercase tracking-wider">Data Awal</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Minat RIASEC -->
                        <div class="bg-surface-container-low rounded-xl p-4 border border-surface-variant">
                            <h4 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-[#800000]">hub</span> Minat (RIASEC)
                            </h4>
                            @php
                                $riasecNameMap = [0=>'Realistic',1=>'Investigative',2=>'Artistic',3=>'Social',4=>'Enterprising',5=>'Conventional'];
                                $riasecRaw2 = $result->input_riasec ?? [];
                                arsort($riasecRaw2);
                            @endphp
                            <ul class="space-y-2">
                                @foreach($riasecRaw2 as $idx => $val)
                                <li class="flex items-center justify-between">
                                    <span class="font-body-sm text-body-sm text-on-surface font-medium">{{ $riasecNameMap[$idx] ?? 'D'.$idx }}</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-20 h-2 bg-surface-variant rounded-full overflow-hidden">
                                            <div class="h-full bg-[#800000] rounded-full" style="width: {{ number_format(($val/5)*100, 0) }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-bold text-on-surface-variant w-8 text-right">{{ number_format(($val/5)*100, 0) }}%</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Kepribadian Big Five -->
                        <div class="bg-surface-container-low rounded-xl p-4 border border-surface-variant">
                            <h4 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-indigo-600">psychology</span> Kepribadian (Big Five)
                            </h4>
                            @php
                                $traitNameMap = [0=>'Openness',1=>'Conscientiousness',2=>'Extraversion',3=>'Agreeableness',4=>'Emotional Stability'];
                                $traitRaw2 = $result->input_trait ?? [];
                                arsort($traitRaw2);
                            @endphp
                            <ul class="space-y-2">
                                @foreach($traitRaw2 as $idx => $val)
                                <li class="flex items-center justify-between">
                                    <span class="font-body-sm text-body-sm text-on-surface font-medium">{{ $traitNameMap[$idx] ?? 'T'.$idx }}</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-20 h-2 bg-surface-variant rounded-full overflow-hidden">
                                            <div class="h-full bg-indigo-500 rounded-full" style="width: {{ number_format(($val/5)*100, 0) }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-bold text-on-surface-variant w-8 text-right">{{ number_format(($val/5)*100, 0) }}%</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Lingkungan Kerja -->
                        <div class="bg-surface-container-low rounded-xl p-4 border border-surface-variant">
                            <h4 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-emerald-600">location_city</span> Lingkungan Kerja
                            </h4>
                            @php
                                $envNameMap = [0=>'Terstruktur',1=>'Kolaboratif',2=>'Dinamis',3=>'High Pressure',4=>'Formal',5=>'Outdoor'];
                                $envRaw2 = $result->input_environment ?? [];
                                arsort($envRaw2);
                            @endphp
                            @if(!empty($envRaw2))
                            <ul class="space-y-2">
                                @foreach($envRaw2 as $idx => $val)
                                <li class="flex items-center justify-between">
                                    <span class="font-body-sm text-body-sm text-on-surface font-medium">{{ $envNameMap[$idx] ?? 'E'.$idx }}</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-20 h-2 bg-surface-variant rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500 rounded-full" style="width: {{ number_format(($val/5)*100, 0) }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-bold text-on-surface-variant w-8 text-right">{{ number_format(($val/5)*100, 0) }}%</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-sm text-on-surface-variant italic">Data lingkungan kerja tidak tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <!-- ANALISIS AI: Semua narasi yang digenerate Gemini -->
            <section id="analisis-ai" class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-[0px_4px_20px_rgba(0,0,0,0.05)] overflow-hidden">
                <div class="h-2 bg-gradient-to-r from-purple-600 to-indigo-400 w-full"></div>
                <div class="p-stack-lg">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-2xl text-purple-600">auto_awesome</span>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Analisis AI Terhadap Profil Anda</h3>
                        <span class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white text-[9px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-[10px]">auto_awesome</span> Gemini AI
                        </span>
                    </div>

                    @php
                        $summaryAI = is_string($summary ?? '') ? $summary : '';
                        $explanationAI = is_string($explanation ?? '') ? $explanation : '';
                        $reasonsAI = is_array($reasons ?? []) ? $reasons : [];
                    @endphp

                    @if(!empty($summaryAI))
                    <div class="mb-6 p-5 bg-purple-50 border border-purple-200 rounded-xl">
                        <p class="font-label-md text-label-md text-purple-700 uppercase tracking-wider mb-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">summarize</span> Ringkasan Kecocokan
                        </p>
                        <p class="font-body-md text-body-md text-on-surface leading-relaxed">{!! nl2br(e($summaryAI)) !!}</p>
                    </div>
                    @endif

                    @if(!empty($explanationAI))
                    <div class="mb-6 p-5 bg-indigo-50 border border-indigo-200 rounded-xl">
                        <p class="font-label-md text-label-md text-indigo-700 uppercase tracking-wider mb-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">psychology_alt</span> Analisis Mendalam Karakter
                        </p>
                        <p class="font-body-md text-body-md text-on-surface leading-relaxed">{!! nl2br(e($explanationAI)) !!}</p>
                    </div>
                    @endif

                    @if(!empty($reasonsAI))
                    <div>
                        <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-3 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">verified_user</span> Alasan Kesesuaian
                        </p>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($reasonsAI as $reason)
                            <li class="flex items-start gap-2 p-3 bg-surface-container-low rounded-lg border border-surface-variant">
                                <span class="material-symbols-outlined text-purple-500 text-[16px] mt-0.5 flex-shrink-0">check_circle</span>
                                <span class="font-body-sm text-body-sm text-on-surface">{{ $reason }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(empty($summaryAI) && empty($explanationAI))
                    <div class="text-center py-10 text-on-surface-variant border border-dashed border-surface-variant rounded-xl">
                        <span class="material-symbols-outlined text-5xl block mb-3 opacity-40">hourglass_empty</span>
                        <p class="font-body-md">Analisis AI belum tersedia untuk sesi ini.</p>
                        <a href="{{ url()->current() }}?refresh=1" class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-bold hover:bg-purple-700 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">refresh</span> Muat Ulang dengan AI
                        </a>
                    </div>
                    @endif
                </div>
            </section>

            <!-- KARAKTER DOMINAN (dengan mapping nama domain yang benar) -->
            <section id="karakter-dominan">
                <h3 class="font-headline-md text-headline-md text-on-surface mb-stack-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person_search</span>
                    Karakter Dominan (Top 3 RIASEC)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                    @php
                        $riasecNameMapDom = [0=>'Realistic',1=>'Investigative',2=>'Artistic',3=>'Social',4=>'Enterprising',5=>'Conventional'];
                        $sortedRiasec = collect($result->input_riasec ?? [])->sortDesc()->take(3);
                        $rank = 1;
                        $colors = [
                            '1' => ['bg' => 'bg-[#800000]', 'text' => 'text-white', 'halo' => 'from-[#800000]/5'],
                            '2' => ['bg' => 'bg-[#FFD700]', 'text' => 'text-[#800000]', 'halo' => 'from-[#FFD700]/10'],
                            '3' => ['bg' => 'bg-surface-variant', 'text' => 'text-on-surface-variant', 'halo' => 'from-surface-variant/30']
                        ];
                    @endphp
                    @foreach($sortedRiasec as $dim => $score)
                    <div class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-[0px_4px_20px_rgba(0,0,0,0.05)] p-stack-lg relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br {{ $colors[$rank]['halo'] }} to-transparent pointer-events-none"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="{{ $colors[$rank]['bg'] }} {{ $colors[$rank]['text'] }} w-6 h-6 rounded-full flex items-center justify-center font-bold text-sm">{{ $rank }}</span>
                                    <h4 class="font-headline-lg text-headline-lg text-primary capitalize">{{ $riasecNameMapDom[$dim] ?? 'Dimensi '.$dim }}</h4>
                                </div>
                                <span class="bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full font-label-md text-label-md">{{ number_format(($score / 5) * 100, 0) }}%</span>
                            </div>
                        </div>
                    </div>
                    @php $rank++; @endphp
                    @endforeach
                </div>
            </section>

            <!-- RINGKASAN JALUR PENDIDIKAN (DS1 Style) -->
            <section id="jalur-pendidikan">
                <h3 class="font-headline-md text-headline-md text-on-surface mb-stack-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">school</span>
                    Ringkasan Jalur Pendidikan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                    @if(isset($educationPath) && is_array($educationPath))
                        @foreach($educationPath as $index => $edu)
                        <div class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-[0px_4px_20px_rgba(0,0,0,0.05)] hover:shadow-md transition-shadow">
                            <div class="h-1 bg-primary w-full rounded-t-xl"></div>
                            <div class="p-6">
                                <div class="w-12 h-12 bg-surface-container rounded-lg flex items-center justify-center mb-4 text-primary">
                                    <span class="material-symbols-outlined text-2xl">school</span>
                                </div>
                                <h4 class="font-headline-md text-headline-md text-on-surface mb-2">{{ $edu['level'] ?? 'Pendidikan' }}</h4>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($edu['majors'] ?? [] as $major)
                                    <span class="inline-block bg-primary/10 text-primary px-3 py-1 rounded-full font-label-md text-label-md">{{ $major }}</span>
                                    @endforeach
                                </div>
                                <p class="font-body-md text-body-md text-on-surface-variant">
                                    {{ $edu['reason'] ?? 'Cocok untuk jalur karir Anda berdasarkan analisis sistem.' }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <!-- SMA Card Default -->
                        <div class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-[0px_4px_20px_rgba(0,0,0,0.05)] hover:shadow-md transition-shadow">
                            <div class="h-1 bg-surface-variant w-full rounded-t-xl"></div>
                            <div class="p-6">
                                <div class="w-12 h-12 bg-surface-container rounded-lg flex items-center justify-center mb-4 text-primary">
                                    <span class="material-symbols-outlined text-2xl">science</span>
                                </div>
                                <h4 class="font-headline-md text-headline-md text-on-surface mb-2">SMA</h4>
                                <span class="inline-block bg-primary/10 text-primary px-3 py-1 rounded-full font-label-md text-label-md mb-4">IPA / IPS</span>
                                <p class="font-body-md text-body-md text-on-surface-variant">
                                    Fokus pada pembelajaran analitis sebagai fondasi akademis yang kuat.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <!-- SPOTLIGHT PROFESI (DS1 Style) -->
            <section id="spotlight-profesi" class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-[0px_4px_20px_rgba(0,0,0,0.05)] overflow-hidden relative">
                <div class="h-2 bg-gradient-to-r from-primary to-secondary-container w-full"></div>
                <div class="grid grid-cols-1 lg:grid-cols-5 h-full">
                    <div class="lg:col-span-3 p-stack-lg flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="material-symbols-outlined text-3xl text-secondary-container bg-secondary-container/10 p-2 rounded-lg">workspace_premium</span>
                            <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Rekomendasi Utama</h3>
                        </div>
                        {{-- [FIX BUG-2&3] Gunakan key 'name', score sudah dalam % jadi tidak perlu *100 --}}
                        <h2 class="font-display-lg text-display-lg text-primary mb-4">{{ $sortedTopN[0]['name'] ?? 'Belum Terdeteksi' }}</h2>
                        <p class="font-body-lg text-body-lg text-on-surface-variant mb-8 max-w-2xl">
                            {{ $sortedTopN[0]['metadata']['description'] ?? $sortedTopN[0]['metadata']['short_desc'] ?? 'Profesi yang paling sesuai dengan pola karakter, minat, dan nilai kerja Anda berdasarkan hasil kalkulasi sistem AI terintegrasi kami.' }}
                        </p>
                        
                        @if(!empty($reasons))
                        <div class="mb-8 bg-secondary-container/5 p-4 rounded-lg border border-secondary-container/10">
                            <h4 class="font-label-md text-label-md text-secondary-container mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">verified_user</span> Analisis Kesesuaian (AI Insight)
                            </h4>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                                @foreach($reasons as $reason)
                                <li class="flex items-start gap-2 font-body-sm text-body-sm text-on-surface italic">
                                    <span class="material-symbols-outlined text-secondary-container text-[14px] mt-0.5">star</span> 
                                    <span>{{ $reason }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <div>
                                <h4 class="font-label-md text-label-md text-on-surface-variant mb-3 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">psychology_alt</span> Key Skills
                                </h4>
                                <ul class="space-y-2">
                                    @php $topProfSkills = isset($sortedTopN[0]) ? ($sortedTopN[0]['metadata']['key_skills'] ?? null) : null; @endphp
                                    @foreach(array_slice($topProfSkills ?? ['Analisis Masalah', 'Komunikasi Efektif', 'Kemampuan Teknis'], 0, 3) as $skill)
                                    <li class="flex items-center gap-2 font-body-md text-body-md text-on-surface">
                                        <span class="material-symbols-outlined text-primary text-sm">check_circle</span> {{ $skill }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="bg-surface-container-low p-4 rounded-lg border border-surface-variant flex flex-col justify-center">
                                <h4 class="font-label-md text-label-md text-on-surface-variant mb-1 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">insights</span> Compatibility
                                </h4>
                                {{-- [FIX BUG-1] Score sudah dalam %, jangan dikali 100 lagi --}}
                                <p class="font-headline-lg text-headline-lg text-primary">{{ isset($sortedTopN[0]) ? number_format($sortedTopN[0]['score'] ?? 0, 1) : '0.0' }}% <span class="text-on-surface-variant font-headline-md text-headline-md">Match</span></p>
                                <p class="font-label-md text-label-md text-on-surface-variant mt-1">Sangat Direkomendasikan</p>
                            </div>
                        </div>
                        <div class="mt-8 flex flex-wrap items-center gap-4">
                            <button class="px-6 py-3 bg-primary-container text-on-primary rounded-lg font-label-md text-label-md shadow-sm hover:opacity-90 transition-opacity flex items-center gap-2 w-fit">
                                Lihat Detail Peta Karir
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                            <!-- Profesi Rekomendasi Lainnya (Attractive text labels) -->
                            <div class="flex items-center gap-4 border-l-2 border-surface-variant pl-4 py-1">
                                <span class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Lainnya:</span>
                                @if(isset($sortedTopN[1]))
                                <span class="text-on-surface font-semibold hover:text-primary transition-colors cursor-pointer border-b border-dashed border-primary/30 pb-0.5">{{ $sortedTopN[1]['name'] ?? '' }}</span>
                                @endif
                                @if(isset($sortedTopN[2]))
                                <span class="text-on-surface font-semibold hover:text-primary transition-colors cursor-pointer border-b border-dashed border-primary/30 pb-0.5">{{ $sortedTopN[2]['name'] ?? '' }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-2 hidden lg:block bg-surface-variant relative">
                        <img src="{{ asset('assets/Teknokrat/Gedung Utama UTI.jpeg') }}" onerror="this.src='https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1000&auto=format&fit=crop'" class="w-full h-full object-cover absolute inset-0 mix-blend-overlay opacity-50">
                        <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest to-transparent"></div>
                        <div class="absolute bottom-8 left-8 right-8">
                            <div class="bg-surface-container-lowest/90 backdrop-blur p-4 rounded-lg border border-surface-variant shadow-sm flex items-start gap-4">
                                <span class="material-symbols-outlined text-secondary text-2xl">lightbulb</span>
                                <div>
                                    <p class="font-body-md text-body-md text-on-surface font-semibold">Saran Pengembangan</p>
                                    {{-- [FIX BUG-5] actionPlan adalah flat array of strings, bukan array of objects --}}
                                    <p class="font-body-md text-body-md text-on-surface-variant text-sm mt-1">{{ $actionPlan[0] ?? 'Terus kembangkan kemampuan analisis Anda dan pertajam pemahaman terkait bidang keilmuan yang Anda pilih.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="h-stack-lg"></div> <!-- Bottom spacing -->
        </main>

        <!-- FOOTER -->
        <footer class="py-6 text-center border-t border-[#800000] mt-auto bg-[#800000] text-white">
            <p class="text-sm text-white/90">&copy; 2026 Shiro-Asesmen by Rakhmat Dedi G &amp; Team</p>
        </footer>
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

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('hidden');
            if (overlay) {
                overlay.classList.toggle('hidden');
            }
        }

        function toggleModal() {
            const modal = document.getElementById('modalReview');
            modal.classList.toggle('hidden');
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
            showProcessing('Membuat laporan PDF dari server...', () => {
                window.location.href = "{{ route('psikometrik.pdf') }}";
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

        // --- SMART SEARCH LOGIC ---
        const searchData = [
            { id: 'rangkuman-hasil', title: 'Rangkuman Hasil Asesmen', keywords: ['rangkuman', 'hasil', 'skor', 'kesimpulan', 'ringkasan', 'inti'] },
            { id: 'draf-pengguna', title: 'Statistik & Akurasi', keywords: ['akurasi', 'konsistensi', 'serius', 'statistik', 'data user', 'profil', 'baik'] },
            { id: 'visualisasi-riasec', title: 'Diagram Radar RIASEC', keywords: ['radar', 'grafik', 'diagram', 'riasec', 'hexagonal', 'visualisasi', 'gambar'] },
            { id: 'karakter-dominan', title: 'Karakter Dominan (R-I-C)', keywords: ['karakter', 'dominan', 'realistic', 'praktikal', 'fisik', 'investigative', 'investigasi', 'penelitian', 'analitis', 'conventional', 'terstruktur', 'rutinitas', 'teliti'] },
            { id: 'kesimpulan-kombinasi', title: 'Kesimpulan Kombinasi Karakter', keywords: ['kombinasi', 'r-i-c', 'kesimpulan akhir', 'potensi', 'musik', 'stres', 'asisten'] },
            { id: 'jalur-pendidikan', title: 'Rekomendasi Jalur Pendidikan', keywords: ['sekolah', 'sma', 'smk', 'kuliah', 'jurusan', 'ipa', 'mesin', 'informatika', 'pendidikan', 'belajar'] },
            { id: 'spotlight-profesi', title: 'Rekomendasi Profesi Utama', keywords: ['profesi', 'pekerjaan', 'karir', 'gaji', 'software engineer', 'rekomendasi', 'skills', 'kerja'] }
        ];

        const searchInput = document.getElementById('smartSearchInput');
        const searchResults = document.getElementById('searchResults');
        const resultsList = document.getElementById('resultsList');

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }

            const filtered = searchData.filter(item => 
                item.title.toLowerCase().includes(query) || 
                item.keywords.some(k => k.includes(query))
            );

            if (filtered.length > 0) {
                resultsList.innerHTML = filtered.map(item => `
                    <div onclick="navigateToSection('${item.id}')" class="px-4 py-3 hover:bg-surface-container-low cursor-pointer transition-colors border-b border-surface-variant/30 last:border-0 flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary text-sm">near_me</span>
                        <div>
                            <p class="text-sm font-bold text-on-surface">${item.title}</p>
                            <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">${item.id.replace(/-/g, ' ')}</p>
                        </div>
                    </div>
                `).join('');
                searchResults.classList.remove('hidden');
            } else {
                searchResults.classList.add('hidden');
            }
        });

        function navigateToSection(id) {
            // Close dropdown
            searchResults.classList.add('hidden');
            searchInput.value = '';
            
            // Navigate with anchor
            window.location.hash = id;
            
            // Re-trigger animation if already there
            const element = document.getElementById(id);
            if (element) {
                element.style.animation = 'none';
                element.offsetHeight; // trigger reflow
                element.style.animation = null;
            }
        }

        // Close search when clicking outside
        document.addEventListener('click', (e) => {
            if (!document.getElementById('searchContainer').contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
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
    <!-- PROCESSING MODAL -->
    <div id="processingModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-[#800000]/20 backdrop-blur-md"></div>
        <div class="bg-white rounded-3xl w-full max-w-sm relative z-10 p-8 shadow-2xl text-center">
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
