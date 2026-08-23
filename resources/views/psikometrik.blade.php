<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>ShiroAsesmen - Psikometrik</title>
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
            <!-- Inactive Tabs -->
            <a class="flex items-center gap-3 px-4 py-3 text-white/70 font-medium hover:text-white hover:bg-white/5 rounded-l-lg transition-colors duration-200" href="{{ route('dashboard.user') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-label-md text-label-md">Dashboard</span>
            </a>
            <!-- Active Tab -->
            <a class="flex items-center gap-3 px-4 py-3 text-[#FFD700] font-bold bg-white/10 border-r-4 border-[#FFD700] rounded-l-lg transition-colors duration-200" href="{{ url('/psikometrik') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">psychology</span>
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
                        <span class="text-lg font-bold text-primary font-headline-md text-headline-md">Psikometrik</span>
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
                            <span class="text-[8px] font-extrabold text-on-surface-variant uppercase tracking-tighter leading-none whitespace-nowrap">{{ session('user_name') ?? (auth()->user()->name ?? 'Guest') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 p-8 max-w-[1280px] w-full mx-auto space-y-12">
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
            
            @php
                $riasecLabels = [
                    'realistic' => 'Realistic (R)',
                    'investigative' => 'Investigative (I)',
                    'artistic' => 'Artistic (A)',
                    'social' => 'Social (S)',
                    'enterprising' => 'Enterprising (E)',
                    'conventional' => 'Conventional (C)'
                ];
                $traitLabels = [
                    'openness' => 'Openness (Keterbukaan)',
                    'conscientiousness' => 'Conscientiousness (Kehati-hatian)',
                    'extraversion' => 'Extraversion (Ekstraversi)',
                    'agreeableness' => 'Agreeableness (Keramahan)',
                    'neuroticism' => 'Neuroticism (Stabilitas Emosi)'
                ];
            @endphp
            <div class="text-[10px] font-bold tracking-widest uppercase text-on-surface-variant mb-[-1rem]">
                SHIROASESMEN &bull; HASIL ASESMEN &bull; <span class="text-primary">PSIKOMETRIK</span>
            </div>

            <!-- Hero / Header -->
            <section class="mb-12 relative rounded-2xl overflow-hidden shadow-lg border border-surface-variant bg-[#800000]">
                <!-- Background Building Image with Blend -->
                <img src="{{ asset('assets/Teknokrat/Gedung Utama UTI.jpeg') }}" onerror="this.src='https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1000&auto=format&fit=crop'" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-30">
                <div class="absolute inset-0 bg-gradient-to-r from-[#800000] to-[#570000]/80"></div>
                <!-- Content -->
                <div class="relative z-10 p-10 flex flex-col md:flex-row items-center justify-between">
                    <div class="w-full">
                        <h2 class="text-3xl font-black text-white italic mb-3 tracking-tight">PROFIL PSIKOMETRIK</h2>
                        <p class="text-white/90 font-body-md max-w-3xl leading-relaxed">
                            Analisis komprehensif mengenai kecenderungan profesional Anda berdasarkan model RIASEC dan Big Five, merinci kekuatan, tantangan, serta lingkungan kerja ideal Anda.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 1: Kesimpulan Kondisi (Bento Grid) -->
            <section class="mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl">insights</span>
                    <h2 class="text-2xl font-bold text-on-surface">Kesimpulan Kondisi</h2>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Dominant Profile Card -->
                    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl border border-surface-variant p-6 relative overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.05)] border-t-[3px] border-t-primary">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                        <div class="flex flex-col sm:flex-row gap-6 items-start relative z-10">
                            <div class="w-24 h-24 rounded-full bg-secondary-container flex items-center justify-center shrink-0 border-4 border-white shadow-sm">
                                <span class="material-symbols-outlined text-[#800000] text-5xl" style="font-variation-settings: 'FILL' 1;">star</span>
                            </div>
                            <div>
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-tertiary-container text-on-tertiary-container font-medium text-xs mb-3">
                                    Karakter Dominan
                                </div>
                                <h3 class="text-xl font-bold text-on-surface mb-2">
                                    RIASEC: <strong>{{ collect($result->input_riasec ?? [])->sortDesc()->take(3)->keys()->map(fn($k) => $riasecLabels[$k] ?? ucfirst($k))->implode(', ') }}</strong> 
                                    | Big Five: <strong>{{ collect($result->input_trait ?? [])->sortDesc()->take(3)->keys()->map(fn($k) => $traitLabels[$k] ?? ucfirst($k))->implode(', ') }}</strong>
                                </h3>
                                <p class="text-sm text-on-surface-variant mb-4">
                                    {{ $explanation['general'] ?? 'Berdasarkan penggabungan nilai dominan Anda, profil Anda sangat kuat dalam mengombinasikan logika pemecahan masalah dengan eksekusi nyata di lapangan.' }}
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-sm font-bold text-primary mb-2 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[16px]">check_circle</span> Kekuatan
                                        </h4>
                                        <ul class="space-y-2">
                                            <li class="text-sm text-on-surface-variant flex items-start gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 shrink-0"></span> Analisis Logis &amp; Terstruktur
                                            </li>
                                            <li class="text-sm text-on-surface-variant flex items-start gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 shrink-0"></span> Keahlian Teknis/Praktis
                                            </li>
                                            <li class="text-sm text-on-surface-variant flex items-start gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 shrink-0"></span> Pengelolaan Data yang Akurat
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-error mb-2 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[16px]">warning</span> Tantangan
                                        </h4>
                                        <ul class="space-y-2">
                                            <li class="text-sm text-on-surface-variant flex items-start gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-error mt-2 shrink-0"></span> Komunikasi Emosional Terbuka
                                            </li>
                                            <li class="text-sm text-on-surface-variant flex items-start gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-error mt-2 shrink-0"></span> Toleransi pada Ambiguitas (situasi yang belum jelas arah atau aturannya)
                                            </li>
                                            <li class="text-sm text-on-surface-variant flex items-start gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-error mt-2 shrink-0"></span> Adaptasi pada Perubahan Mendadak
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Visual Anchor -->
                    <div class="bg-surface-container-lowest rounded-xl border border-surface-variant overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.05)] border-t-[3px] border-t-secondary-container">
                        <img alt="Abstract representation of balance" class="w-full h-48 object-cover" src="{{ asset('assets/Teknokrat/Gedung UTI Baru.png') }}" onerror="this.src='https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1000&auto=format&fit=crop'"/>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-on-surface mb-2">Harmoni Karakter</h3>
                            <p class="text-sm text-on-surface-variant">Profil Anda menunjukkan perpaduan unik antara 3 minat utama (<strong>Realistic, Investigative, Conventional</strong>) dan 3 karakter dasar (<strong>Conscientiousness, Openness, Agreeableness</strong>). Hal ini membuat Anda sangat efektif di lingkungan yang terstruktur namun tetap mengizinkan eksplorasi ide baru.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 1.5: Pengenalan Konsep -->
            <section class="mb-12">
                <div class="bg-surface-container-low rounded-xl border border-surface-variant p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-on-surface mb-4">Memahami Profil Anda</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-bold text-primary mb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined">work</span> Minat Pekerjaan (RIASEC)
                            </h4>
                            <p class="text-sm text-on-surface-variant">
                                Teori Holland (RIASEC) mengelompokkan minat kerja ke dalam enam tipe karakter: Realistic, Investigative, Artistic, Social, Enterprising, dan Conventional. Ini membantu memetakan jenis tugas dan suasana kerja di mana Anda akan merasa paling nyaman dan bersemangat.
                            </p>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-primary mb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined">psychology</span> Karakter Kepribadian (Big Five)
                            </h4>
                            <p class="text-sm text-on-surface-variant">
                                Big Five Personality adalah metode yang paling banyak digunakan untuk menggambarkan karakter dasar manusia melalui lima sisi: Openness (Keterbukaan), Conscientiousness (Kehati-hatian), Extraversion (Ekstraversi), Agreeableness (Keramahan), dan Neuroticism (Stabilitas Emosi). Ini memprediksi gaya kerja dan cara Anda berhubungan dengan orang lain.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 2: Domain Score Ranking -->
            <section class="mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl">bar_chart</span>
                    <h2 class="text-2xl font-bold text-on-surface">Peringkat Skor Domain</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- RIASEC Block -->
                    <div class="bg-surface-container-lowest rounded-xl border border-surface-variant p-8 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border-t-[2px] border-t-primary">
                        <h3 class="text-lg font-bold text-on-surface mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">work</span> Minat Pekerjaan (RIASEC)
                        </h3>
                        <div class="space-y-5">
                            @php
                                $riasecLabels = [
                                    0 => 'Realistic (R)',
                                    1 => 'Investigative (I)',
                                    2 => 'Artistic (A)',
                                    3 => 'Social (S)',
                                    4 => 'Enterprising (E)',
                                    5 => 'Conventional (C)'
                                ];
                                $userRiasec = collect($result->input_riasec ?? [])->sortDesc();
                            @endphp
                            @foreach($userRiasec as $dim => $score)
                            <div>
                                <div class="flex justify-between items-end mb-2">
                                    <span class="text-sm font-medium text-on-surface">{{ $riasecLabels[$dim] ?? ucfirst($dim) }}</span>
                                    <span class="text-sm font-bold text-primary">{{ number_format(($score / 5) * 100, 0) }}%</span>
                                </div>
                                <div class="w-full bg-surface-container h-3 rounded-full overflow-hidden">
                                    <div class="bg-primary h-full rounded-full" style="width: {{ ($score / 5) * 100 }}%;"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- BIG 5 Block -->
                    <div class="bg-surface-container-lowest rounded-xl border border-surface-variant p-8 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border-t-[2px] border-t-secondary-container">
                        <h3 class="text-lg font-bold text-on-surface mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#800000]">psychology</span> Karakter Kepribadian (Big Five)
                        </h3>
                        <div class="space-y-5">
                            @php
                                $traitLabels = [
                                    0 => 'Openness (Keterbukaan)',
                                    1 => 'Conscientiousness (Kehati-hatian)',
                                    2 => 'Extraversion (Ekstraversi)',
                                    3 => 'Agreeableness (Keramahan)',
                                    4 => 'Neuroticism (Stabilitas Emosi)'
                                ];
                                $userTraits = collect($result->input_trait ?? [])->sortDesc();
                            @endphp
                            @foreach($userTraits as $dim => $score)
                            <div>
                                <div class="flex justify-between items-end mb-2">
                                    <span class="text-sm font-medium text-on-surface">{{ $traitLabels[$dim] ?? ucfirst($dim) }}</span>
                                    <span class="text-sm font-bold text-[#800000]">{{ number_format(($score / 5) * 100, 0) }}%</span>
                                </div>
                                <div class="w-full bg-surface-container h-3 rounded-full overflow-hidden">
                                    <div class="bg-[#800000] h-full rounded-full" style="width: {{ ($score / 5) * 100 }}%;"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 3: Deep Dive Explanations - Accordion Layout -->
            <section class="mb-12" id="section-wawasan">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-primary text-3xl">menu_book</span>
                    <h2 class="text-2xl font-bold text-on-surface">Wawasan Domain Mendalam</h2>
                </div>
                <p class="text-sm text-on-surface-variant mb-6">Pilih domain yang ingin Anda eksplorasi lebih lanjut. Klik judul untuk membaca analisis lengkap.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri: Minat Pekerjaan (RIASEC) -->
                    <div>
                        <h3 class="text-base font-bold text-primary mb-4 flex items-center gap-2 border-b-2 border-primary/20 pb-2">
                            <span class="material-symbols-outlined">work</span> Minat Pekerjaan (RIASEC)
                        </h3>
                        <div class="space-y-3" id="accordion-riasec">

                            <!-- R: Realistic (88% - DOMINAN) -->
                            <div class="rounded-xl border border-surface-variant bg-surface-container-lowest shadow-sm overflow-hidden border-l-4 border-l-primary">
                                <button onclick="toggleAccordion('r-realistic')" class="w-full flex items-center justify-between p-4 text-left hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary text-[20px]">build</span>
                                        <span class="font-semibold text-on-surface">Realistic (R)</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-primary/10 text-primary uppercase">88% · Dominan</span>
                                    </div>
                                    <span id="icon-r-realistic" class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                                </button>
                                <div id="r-realistic" class="hidden px-4 pb-4">
                                    <p class="text-sm text-on-surface-variant mb-3">Anda secara alami tertarik pada hal-hal yang bersifat fisik dan terukur. Pendekatan utama Anda adalah <em>learning by doing</em> (belajar sambil mempraktikkan langsung) — lebih suka bekerja langsung dengan alat, mesin, atau perangkat lunak yang menghasilkan hasil kerja nyata.</p>
                                    <div class="pt-3 border-t border-surface-variant">
                                        <span class="text-xs font-bold text-[#800000]">Dampak Pendidikan & Karir:</span>
                                        <p class="text-sm text-on-surface-variant mt-1 mb-2"><strong>Dalam proses pendidikan</strong>, Anda akan lebih termotivasi pada pelajaran berbasis praktik fisik atau karya nyata.</p>
                                        <p class="text-sm text-on-surface-variant"><strong>Saat menjalankan karir</strong>, Anda sangat cocok untuk bidang teknik mesin, konstruksi jaringan, dan berbagai peran yang bersifat <em>hands-on</em> (terjun langsung ke lapangan/praktik) dalam membangun dan memelihara sistem.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- I: Investigative (76% - DOMINAN) -->
                            <div class="rounded-xl border border-surface-variant bg-surface-container-lowest shadow-sm overflow-hidden border-l-4 border-l-primary">
                                <button onclick="toggleAccordion('r-investigative')" class="w-full flex items-center justify-between p-4 text-left hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary text-[20px]">science</span>
                                        <span class="font-semibold text-on-surface">Investigative (I)</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-primary/10 text-primary uppercase">76% · Dominan</span>
                                    </div>
                                    <span id="icon-r-investigative" class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                                </button>
                                <div id="r-investigative" class="hidden px-4 pb-4">
                                    <p class="text-sm text-on-surface-variant mb-3">Anda memiliki rasa ingin tahu yang tinggi dan sangat analitis (suka mengurai data secara logis). Tidak cukup hanya mengetahui bahwa sesuatu berfungsi — Anda ingin memahami <em>bagaimana</em> dan <em>mengapa</em> hal itu berfungsi, mendorong Anda untuk menggali lebih dalam dari permukaan.</p>
                                    <div class="pt-3 border-t border-surface-variant">
                                        <span class="text-xs font-bold text-[#800000]">Dampak Pendidikan & Karir:</span>
                                        <p class="text-sm text-on-surface-variant mt-1 mb-2"><strong>Dalam proses pendidikan</strong>, Anda akan sangat menikmati pendalaman materi sains, matematika, atau eksplorasi kasus-kasus rumit.</p>
                                        <p class="text-sm text-on-surface-variant"><strong>Saat menjalankan karir</strong>, hal ini mendukung kuat posisi di bidang penelitian, pengolahan data, keamanan siber, dan peran teknis yang memerlukan pemikiran mendalam.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- C: Conventional (64% - DOMINAN) -->
                            <div class="rounded-xl border border-surface-variant bg-surface-container-lowest shadow-sm overflow-hidden border-l-4 border-l-primary">
                                <button onclick="toggleAccordion('r-conventional')" class="w-full flex items-center justify-between p-4 text-left hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary text-[20px]">table_chart</span>
                                        <span class="font-semibold text-on-surface">Conventional (C)</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-primary/10 text-primary uppercase">64% · Dominan</span>
                                    </div>
                                    <span id="icon-r-conventional" class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                                </button>
                                <div id="r-conventional" class="hidden px-4 pb-4">
                                    <p class="text-sm text-on-surface-variant mb-3">Anda memiliki kecenderungan untuk menghargai keteraturan, prosedur yang jelas, dan standar yang baku. Ini adalah kekuatan yang menjadikan Anda seseorang yang dapat diandalkan untuk menjaga kualitas dan ketelitian dalam pekerjaan teknis.</p>
                                    <div class="pt-3 border-t border-surface-variant">
                                        <span class="text-xs font-bold text-[#800000]">Dampak Pendidikan & Karir:</span>
                                        <p class="text-sm text-on-surface-variant mt-1 mb-2"><strong>Dalam proses pendidikan</strong>, Anda akan berprestasi baik pada bidang ilmu pasti atau tugas yang membutuhkan laporan terstruktur.</p>
                                        <p class="text-sm text-on-surface-variant"><strong>Saat menjalankan karir</strong>, di lingkungan profesional, ini membuat Anda unggul dalam peran yang memerlukan ketepatan tinggi seperti penjamin kualitas produk, analisis sistem, atau pengelola data.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- E: Enterprising (52% - NETRAL) -->
                            <div class="rounded-xl border border-surface-variant bg-surface-container-lowest shadow-sm overflow-hidden border-l-4 border-l-outline">
                                <button onclick="toggleAccordion('r-enterprising')" class="w-full flex items-center justify-between p-4 text-left hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[20px]">trending_up</span>
                                        <span class="font-semibold text-on-surface">Enterprising (E)</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-surface-container text-on-surface-variant uppercase">52%</span>
                                    </div>
                                    <span id="icon-r-enterprising" class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                                </button>
                                <div id="r-enterprising" class="hidden px-4 pb-4">
                                    <p class="text-sm text-on-surface-variant mb-3">Anda memiliki potensi kepemimpinan dan kemampuan meyakinkan orang lain yang seimbang. Ini berarti Anda bisa menjadi jembatan yang baik antara tim teknis dan tim lapangan — memahami keduanya namun tidak terdorong untuk mendominasi pembicaraan secara berlebihan.</p>
                                    <div class="pt-3 border-t border-surface-variant">
                                        <span class="text-xs font-bold text-[#800000]">Dampak Pendidikan & Karir:</span>
                                        <p class="text-sm text-on-surface-variant mt-1 mb-2"><strong>Dalam proses pendidikan</strong>, Anda akan sering menonjol dalam debat, presentasi tugas kelompok, atau kepanitiaan.</p>
                                        <p class="text-sm text-on-surface-variant"><strong>Saat menjalankan karir</strong>, mengasah sisi ini akan membuka jalur karir menuju peran manajerial, pemimpin tim, atau wirausaha yang butuh kemampuan memengaruhi orang lain.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- S: Social (35% - DI BAWAH 50%) -->
                            <div class="rounded-xl border border-surface-variant bg-surface-container-lowest shadow-sm overflow-hidden border-l-4 border-l-surface-dim">
                                <button onclick="toggleAccordion('r-social')" class="w-full flex items-center justify-between p-4 text-left hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[20px]">group</span>
                                        <span class="font-semibold text-on-surface">Social (S)</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-surface-container-high text-on-surface-variant uppercase">35%</span>
                                    </div>
                                    <span id="icon-r-social" class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                                </button>
                                <div id="r-social" class="hidden px-4 pb-4">
                                    <p class="text-sm text-on-surface-variant mb-3">Preferensi Anda lebih condong pada pekerjaan mandiri atau dalam tim kecil, dibandingkan pekerjaan yang mengharuskan banyak interaksi tatap muka secara terus-menerus. Ini bukan kelemahan — ini adalah tanda bahwa energi Anda paling efektif digunakan saat fokus pada tugas teknis.</p>
                                    <div class="pt-3 border-t border-surface-variant">
                                        <span class="text-xs font-bold text-[#800000]">Dampak Pendidikan & Karir:</span>
                                        <p class="text-sm text-on-surface-variant mt-1 mb-2"><strong>Dalam proses pendidikan</strong>, Anda mungkin lebih nyaman belajar mandiri atau dengan tutor pribadi dibandingkan dalam kelompok besar.</p>
                                        <p class="text-sm text-on-surface-variant"><strong>Saat menjalankan karir</strong>, ini adalah keuntungan besar untuk menuntaskan tugas rumit yang butuh fokus tinggi tanpa banyak gangguan interaksi sosial.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- A: Artistic (28% - DI BAWAH 50%) -->
                            <div class="rounded-xl border border-surface-variant bg-surface-container-lowest shadow-sm overflow-hidden border-l-4 border-l-surface-dim">
                                <button onclick="toggleAccordion('r-artistic')" class="w-full flex items-center justify-between p-4 text-left hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[20px]">palette</span>
                                        <span class="font-semibold text-on-surface">Artistic (A)</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-surface-container-high text-on-surface-variant uppercase">28%</span>
                                    </div>
                                    <span id="icon-r-artistic" class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                                </button>
                                <div id="r-artistic" class="hidden px-4 pb-4">
                                    <p class="text-sm text-on-surface-variant mb-3">Minat Anda pada ekspresi kreatif yang bebas cenderung lebih rendah. Namun, kreativitas Anda hadir dalam bentuk yang berbeda, yaitu solusi teknis yang cerdas dan cara berpikir sistematis yang inovatif (menemukan cara baru yang lebih efektif).</p>
                                    <div class="pt-3 border-t border-surface-variant">
                                        <span class="text-xs font-bold text-[#800000]">Dampak Pendidikan & Karir:</span>
                                        <p class="text-sm text-on-surface-variant mt-1 mb-2"><strong>Dalam proses pendidikan</strong>, Anda lebih menyukai solusi praktis dan efisien dibanding sekadar estetika.</p>
                                        <p class="text-sm text-on-surface-variant"><strong>Saat menjalankan karir</strong>, daya pikir sistematis ini berharga dalam merancang antarmuka aplikasi atau mendesain tata letak sistem fungsional yang berfokus pada kemudahan pengguna.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Kolom Kanan: Karakter Kepribadian (Big Five) -->
                    <div>
                        <h3 class="text-base font-bold text-[#800000] mb-4 flex items-center gap-2 border-b-2 border-[#800000]/20 pb-2">
                            <span class="material-symbols-outlined">psychology</span> Karakter Kepribadian (Big Five)
                        </h3>
                        <div class="space-y-3" id="accordion-big5">

                            <!-- C: Conscientiousness (85% - DOMINAN) -->
                            <div class="rounded-xl border border-surface-variant bg-surface-container-lowest shadow-sm overflow-hidden border-l-4 border-l-[#800000]">
                                <button onclick="toggleAccordion('b-conscientiousness')" class="w-full flex items-center justify-between p-4 text-left hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-[#800000] text-[20px]">task_alt</span>
                                        <span class="font-semibold text-on-surface">Conscientiousness</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-[#800000]/10 text-[#800000] uppercase">85% · Dominan</span>
                                    </div>
                                    <span id="icon-b-conscientiousness" class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                                </button>
                                <div id="b-conscientiousness" class="hidden px-4 pb-4">
                                    <p class="text-sm text-on-surface-variant mb-3">Anda adalah individu yang teratur, disiplin, dan sangat bertanggung jawab. Anda menetapkan standar tinggi untuk diri sendiri dan cenderung menyelesaikan apa yang telah Anda mulai dengan teliti hingga tuntas.</p>
                                    <div class="pt-3 border-t border-surface-variant">
                                        <span class="text-xs font-bold text-[#800000]">Dampak Pendidikan & Karir:</span>
                                        <p class="text-sm text-on-surface-variant mt-1 mb-2"><strong>Dalam proses pendidikan</strong>, karakter ini adalah kunci unggul dalam disiplin belajar dan jarang mengabaikan tugas.</p>
                                        <p class="text-sm text-on-surface-variant"><strong>Saat menjalankan karir</strong>, dalam karir jangka panjang, Anda sangat diandalkan memimpin proyek krusial, menjaga standar kualitas, dan memastikan segala hal terdokumentasi dengan baik.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- O: Openness (78% - DOMINAN) -->
                            <div class="rounded-xl border border-surface-variant bg-surface-container-lowest shadow-sm overflow-hidden border-l-4 border-l-[#800000]">
                                <button onclick="toggleAccordion('b-openness')" class="w-full flex items-center justify-between p-4 text-left hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-[#800000] text-[20px]">lightbulb</span>
                                        <span class="font-semibold text-on-surface">Openness</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-[#800000]/10 text-[#800000] uppercase">78% · Dominan</span>
                                    </div>
                                    <span id="icon-b-openness" class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                                </button>
                                <div id="b-openness" class="hidden px-4 pb-4">
                                    <p class="text-sm text-on-surface-variant mb-3">Anda terbuka terhadap gagasan baru, senang belajar hal-hal yang belum pernah dicoba, dan nyaman dengan masalah yang rumit. Pikiran Anda aktif mencari kemungkinan-kemungkinan baru bahkan di luar bidang utama Anda.</p>
                                    <div class="pt-3 border-t border-surface-variant">
                                        <span class="text-xs font-bold text-[#800000]">Dampak Pendidikan & Karir:</span>
                                        <p class="text-sm text-on-surface-variant mt-1 mb-2"><strong>Dalam proses pendidikan</strong>, karakter ini sangat kuat saat meriset materi baru atau mengeksplorasi ilmu di luar zona nyaman.</p>
                                        <p class="text-sm text-on-surface-variant"><strong>Saat menjalankan karir</strong>, di dunia kerja, sifat ini menjadikan Anda individu yang sangat fleksibel dan cepat tanggap terhadap perubahan teknologi yang sangat cepat dan besar.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- A: Agreeableness (68%) -->
                            <div class="rounded-xl border border-surface-variant bg-surface-container-lowest shadow-sm overflow-hidden border-l-4 border-l-outline">
                                <button onclick="toggleAccordion('b-agreeableness')" class="w-full flex items-center justify-between p-4 text-left hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[20px]">handshake</span>
                                        <span class="font-semibold text-on-surface">Agreeableness</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-surface-container text-on-surface-variant uppercase">68%</span>
                                    </div>
                                    <span id="icon-b-agreeableness" class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                                </button>
                                <div id="b-agreeableness" class="hidden px-4 pb-4">
                                    <p class="text-sm text-on-surface-variant mb-3">Anda memiliki keseimbangan yang baik antara kerja sama tim dan ketegasan prinsip. Anda bisa berkolaborasi dengan hangat namun tidak mudah goyah oleh tekanan orang lain — ciri pemikir mandiri yang tetap bisa bekerja dalam tim.</p>
                                    <div class="pt-3 border-t border-surface-variant">
                                        <span class="text-xs font-bold text-[#800000]">Dampak Pendidikan & Karir:</span>
                                        <p class="text-sm text-on-surface-variant mt-1 mb-2"><strong>Dalam proses pendidikan</strong>, di lingkungan sekolah/kampus, Anda mudah berbaur dan sering mengambil jalan tengah.</p>
                                        <p class="text-sm text-on-surface-variant"><strong>Saat menjalankan karir</strong>, hal ini sangat menguntungkan di dunia kerja ketika Anda dituntut menjadi komunikator penengah antar departemen yang berbeda ego dan kepentingannya.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- E: Extraversion (42% - DI BAWAH 50%) -->
                            <div class="rounded-xl border border-surface-variant bg-surface-container-lowest shadow-sm overflow-hidden border-l-4 border-l-surface-dim">
                                <button onclick="toggleAccordion('b-extraversion')" class="w-full flex items-center justify-between p-4 text-left hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[20px]">record_voice_over</span>
                                        <span class="font-semibold text-on-surface">Extraversion</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-surface-container-high text-on-surface-variant uppercase">42%</span>
                                    </div>
                                    <span id="icon-b-extraversion" class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                                </button>
                                <div id="b-extraversion" class="hidden px-4 pb-4">
                                    <p class="text-sm text-on-surface-variant mb-3">Anda cenderung mendapatkan energi dari waktu untuk berpikir dan bekerja secara mandiri. Ini adalah kualitas yang sangat berharga untuk pekerjaan yang memerlukan konsentrasi tinggi — hal yang justru sering menjadi tantangan bagi orang yang terlalu suka keramaian.</p>
                                    <div class="pt-3 border-t border-surface-variant">
                                        <span class="text-xs font-bold text-[#800000]">Dampak Pendidikan & Karir:</span>
                                        <p class="text-sm text-on-surface-variant mt-1 mb-2"><strong>Dalam proses pendidikan</strong>, karena tidak terlalu bergantung pada energi keramaian, Anda bisa berjam-jam tenggelam mempelajari topik rumit.</p>
                                        <p class="text-sm text-on-surface-variant"><strong>Saat menjalankan karir</strong>, di tempat kerja, ini adalah kekuatan mahal untuk mendiagnosis masalah teknis berat tanpa terpengaruh oleh suasana bising di sekitar.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- N: Neuroticism (34% - DI BAWAH 50% - POSITIF berarti stabil) -->
                            <div class="rounded-xl border border-surface-variant bg-surface-container-lowest shadow-sm overflow-hidden border-l-4 border-l-[#800000]">
                                <button onclick="toggleAccordion('b-neuroticism')" class="w-full flex items-center justify-between p-4 text-left hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-[#800000] text-[20px]">self_improvement</span>
                                        <span class="font-semibold text-on-surface">Neuroticism</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-[#800000]/10 text-[#800000] uppercase">34% · Stabil</span>
                                    </div>
                                    <span id="icon-b-neuroticism" class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                                </button>
                                <div id="b-neuroticism" class="hidden px-4 pb-4">
                                    <p class="text-sm text-on-surface-variant mb-3">Skor yang rendah di bagian ini menunjukkan Anda memiliki kestabilan emosi yang kuat. Anda cenderung tenang menghadapi tekanan, tidak mudah panik dalam situasi sulit, dan bisa bangkit kembali dengan cepat dari masalah.</p>
                                    <div class="pt-3 border-t border-surface-variant">
                                        <span class="text-xs font-bold text-[#800000]">Dampak Pendidikan & Karir:</span>
                                        <p class="text-sm text-on-surface-variant mt-1 mb-2"><strong>Dalam proses pendidikan</strong>, memberi Anda tingkat ketahanan stres yang tinggi saat berhadapan dengan tumpukan tugas ujian atau tenggat waktu mendesak.</p>
                                        <p class="text-sm text-on-surface-variant"><strong>Saat menjalankan karir</strong>, di dunia nyata, pikiran rasional Anda akan sangat diandalkan untuk menyelamatkan proyek dari kepanikan di detik-detik kritis.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>


            <!-- Section 4: Work Environment Preference -->
            <section class="mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl">domain</span>
                    <h2 class="text-2xl font-bold text-on-surface">Preferensi Lingkungan Kerja</h2>
                </div>
                <div class="bg-surface-container-lowest rounded-xl border border-surface-variant overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.05)] flex flex-col md:flex-row">
                    <div class="md:w-1/3 relative min-h-[250px] bg-surface-variant">
                        <img alt="Modern workspace" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay" src="{{ asset('assets/Teknokrat/Gedung Utama UTI.jpeg') }}" onerror="this.src='https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1000&auto=format&fit=crop'"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest to-transparent md:hidden"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent to-surface-container-lowest hidden md:block"></div>
                    </div>
                    <div class="p-8 md:w-2/3 flex flex-col justify-center relative z-10 bg-surface-container-lowest">
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-secondary-container text-[#800000] font-bold text-xs mb-4 w-fit">
                            Terstruktur &amp; Fokus
                        </div>
                        <h3 class="text-xl font-bold text-on-surface mb-4">Lingkungan Profesional Ideal Anda</h3>
                        <p class="text-base text-on-surface-variant mb-4">
                            Lingkungan optimal Anda menyeimbangkan kebebasan teknis dengan tujuan sistem yang jelas. Anda membutuhkan otonomi (kebebasan atau kemandirian dalam mengambil keputusan) untuk membangun dan memperbaiki infrastruktur (kode/alat), namun tetap mengandalkan aturan teknis (C) yang baku. Lingkungan yang terlalu banyak interaksi sosial tak terstruktur dapat menguras energi Anda.
                        </p>
                        <div class="bg-[#800000]/5 p-4 rounded-lg mb-6 border border-[#800000]/10">
                            <h4 class="text-sm font-bold text-[#800000] mb-2">Pengaruh Terhadap Pendidikan &amp; Karir:</h4>
                            <p class="text-sm text-on-surface-variant mb-3">
                                <strong>Dalam proses pendidikan</strong>, Anda akan lebih berprestasi pada metode pembelajaran berbasis proyek nyata <em>(project-based learning</em> — belajar sambil mengerjakan proyek langsung) daripada sekadar teori di kelas.
                            </p>
                            <p class="text-sm text-on-surface-variant">
                                <strong>Saat menjalankan karir kelak</strong>, berada di lingkungan yang menghargai keteraturan dan fokus teknis ini akan secara drastis mempercepat kurva (proses perkembangan) penguasaan keahlian Anda, mencegah <em>burnout</em> (stres atau kelelahan mental yang hebat dalam menjalani sesuatu), dan memaksimalkan hasil kerja profesional Anda secara konsisten.
                            </p>
                        </div>
                        <div class="mb-5">
                            <h4 class="text-sm font-bold text-on-surface mb-2">Daftar Periksa Lingkungan Ideal:</h4>
                            <p class="text-xs text-on-surface-variant mb-4 italic">Gunakan poin-poin di bawah ini sebagai panduan saat memilih tempat kuliah atau bekerja untuk memastikan lingkungan tersebut mendukung potensi maksimal Anda.</p>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3 text-sm text-on-surface">
                                <span class="material-symbols-outlined text-primary shrink-0 mt-0.5">done</span> 
                                <span>Akses ke perangkat keras/lunak yang memadai (fasilitas alat pendukung kerja yang lengkap)</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm text-on-surface">
                                <span class="material-symbols-outlined text-primary shrink-0 mt-0.5">done</span> 
                                <span>Pekerjaan berbasis project dengan output jelas (memiliki target dan hasil akhir yang pasti)</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm text-on-surface">
                                <span class="material-symbols-outlined text-primary shrink-0 mt-0.5">done</span> 
                                <span>Minim distraksi birokrasi yang berlebihan (tidak terlalu banyak aturan administratif yang mengganggu fokus kerja)</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            
            <div class="h-16"></div>
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

        function toggleAccordion(id) {
            const content = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            if (content && icon) {
                const isHidden = content.classList.contains('hidden');
                content.classList.toggle('hidden', !isHidden);
                icon.style.transform = isHidden ? 'rotate(180deg)' : '';
            }
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
