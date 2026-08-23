<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>ShiroAsesmen - Pengembangan Diri</title>
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

    // Helper to get top traits/RIASEC
    $topRiasec = collect($result->input_riasec ?? [])->sortDesc()->keys()->take(3)->toArray();
    $topBigFive = collect($result->input_trait ?? [])->sortDesc()->keys()->take(3)->toArray();
@endphp
<body class="bg-background text-on-background font-body-md selection:bg-primary-container selection:text-on-primary-container min-h-screen flex">
    
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
            <a class="flex items-center gap-3 px-4 py-3 text-white/70 font-medium hover:text-white hover:bg-white/5 rounded-l-lg transition-colors duration-200" href="{{ url('/peta-pendidikan') }}">
                <span class="material-symbols-outlined">map</span>
                <span class="font-label-md text-label-md">Peta Pendidikan</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-white/70 font-medium hover:text-white hover:bg-white/5 rounded-l-lg transition-colors duration-200" href="{{ url('/peta-profesi') }}">
                <span class="material-symbols-outlined">work</span>
                <span class="font-label-md text-label-md">Peta Profesi</span>
            </a>
            <!-- Active Tab -->
            <a class="flex items-center gap-3 px-4 py-3 text-[#FFD700] font-bold bg-white/10 border-r-4 border-[#FFD700] rounded-l-lg transition-colors duration-200" href="{{ url('/pengembangan-diri') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">trending_up</span>
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
                        <span class="text-lg font-bold text-primary font-headline-md text-headline-md">Pengembangan Diri</span>
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
                        <div class="font-bold">Nama: {{ auth()->user()->name ?? 'Guest' }}</div>
                        <div>ID Asesmen: SA-{{ \Carbon\Carbon::parse($result->created_at)->format('Ymd') }}-{{ sprintf('%03d', $result->id) }}</div>
                    </div>
                    <div class="text-xs text-on-surface-variant italic">Dicetak pada: <span id="printDate"></span></div>
                </div>
            </div>
            <div class="text-[10px] font-bold tracking-widest uppercase text-on-surface-variant mb-[-1rem]">
                SHIROASESMEN &bull; HASIL Asesmen &bull; <span class="text-primary">PENGEMBANGAN DIRI</span>
            </div>

            <section class="mb-12 relative rounded-2xl overflow-hidden shadow-lg border border-surface-variant bg-[#800000]">
                <img src="{{ asset('assets/Teknokrat/Gedung Utama UTI.jpeg') }}" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-30">
                <div class="absolute inset-0 bg-gradient-to-r from-[#800000] to-[#570000]/80"></div>
                <div class="relative z-10 p-10">
                    <h2 class="text-3xl font-black text-white italic mb-3 tracking-tight uppercase">Eksplorasi Pengembangan Diri</h2>
                    <p class="text-white/90 font-body-md max-w-3xl leading-relaxed">
                        Halaman ini akan menyajikan saran pengembangan diri untuk mengoptimalkan potensi dan mengatasi tantangan berdasarkan profil unik Anda. Konten sedang disiapkan.
                    </p>
                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Area 1: Penguat Domain Utama -->
                <div class="bg-surface rounded-2xl border border-surface-variant shadow-sm overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-surface-variant bg-primary/5">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-primary rounded-lg text-white">
                                <span class="material-symbols-outlined">trending_up</span>
                            </div>
                            <h3 class="text-xl font-bold text-on-surface">Katalisator Kemampuan</h3>
                        </div>
                        <p class="text-sm text-on-surface-variant">Penguat Karakter Utama ({{ implode(', ', array_map(fn($k) => $riasecLabels[$k] ?? $k, array_slice($topRiasec, 0, 2))) }}, {{ $traitLabels[$topBigFive[0]] ?? $topBigFive[0] }})</p>
                    </div>
                    <div class="p-6 flex-1 flex flex-col gap-5">
                        <div>
                            <h4 class="text-sm font-bold text-primary mb-2 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">psychology</span> Fokus Pengembangan</h4>
                            <p class="text-sm text-on-surface-variant leading-relaxed">
                                Memperkuat domain dominan Anda tidak harus selalu melalui jalur teknis yang linier. Kemampuan dapat diasah secara tak langsung—seperti berorganisasi untuk melatih kedisiplinan (<strong>{{ $traitLabels[$topBigFive[0]] ?? '' }}</strong>), hingga aktivitas yang menstimulasi nalar kritis (<strong>{{ $riasecLabels[$topRiasec[1]] ?? '' }}</strong>) dan ketahanan (<strong>{{ $riasecLabels[$topRiasec[0]] ?? '' }}</strong>).
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-primary mb-2 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">alt_route</span> Jalur Pengembangan</h4>
                            <ul class="space-y-3 text-sm text-on-surface-variant">
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-secondary mt-0.5">build</span>
                                    <span><strong>Praktik Langsung:</strong> Mengikuti program magang atau kompetisi yang relevan untuk menguji keandalan Anda dalam domain <strong>{{ $riasecLabels[$topRiasec[0]] ?? '' }}</strong>.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-secondary mt-0.5">movie</span>
                                    <span><strong>Stimulasi Kognitif:</strong> Gunakan media (film/buku) yang menantang nalar analitis Anda sesuai profil <strong>{{ $riasecLabels[$topRiasec[1]] ?? '' }}</strong>.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-secondary mt-0.5">groups</span>
                                    <span><strong>Penguatan Karakter:</strong> Aktif di organisasi kampus untuk mengelola tanggung jawab yang mengasah <strong>{{ $traitLabels[$topBigFive[0]] ?? '' }}</strong> Anda.</span>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-auto pt-4 border-t border-surface-variant">
                            <h4 class="text-sm font-bold text-green-700 mb-1 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">check_circle</span> Dampak Positif</h4>
                            <p class="text-[13px] text-on-surface-variant italic">Memaksimalkan keunggulan kompetitif Anda di dunia profesional masa depan.</p>
                        </div>
                    </div>
                </div>

                <!-- Area 2: Pelepas Stres -->
                <div class="bg-surface rounded-2xl border border-surface-variant shadow-sm overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-surface-variant bg-tertiary/5">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-tertiary rounded-lg text-white">
                                <span class="material-symbols-outlined">self_improvement</span>
                            </div>
                            <h3 class="text-xl font-bold text-on-surface">Pelepas Stres</h3>
                        </div>
                        <p class="text-sm text-on-surface-variant">Penyeimbang Mental (<i>Stress Reliever</i>)</p>
                    </div>
                    <div class="p-6 flex-1 flex flex-col gap-5">
                        <div>
                            <h4 class="text-sm font-bold text-tertiary mb-2 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">interests</span> Fokus Aktivitas</h4>
                            <p class="text-sm text-on-surface-variant leading-relaxed">
                                <strong>Analisis Profil:</strong> Dominasi <strong>{{ $riasecLabels[$topRiasec[0]] ?? '' }}</strong> menunjukkan Anda pulih melalui aktivitas nyata. Namun, profil <strong>{{ $traitLabels[$topBigFive[2]] ?? '' }}</strong> Anda menunjukkan Anda membutuhkan waktu sendiri untuk mengisi energi.<br><br>
                                <strong>Saran Penyeimbang:</strong> Pilihlah hobi yang melibatkan aktivitas fisik atau teknis namun bersifat individual. Ini akan menyegarkan pikiran tanpa menguras energi sosial Anda.
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-tertiary mb-2 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">alt_route</span> Jalur Pengembangan</h4>
                            <ul class="space-y-3 text-sm text-on-surface-variant">
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-tertiary mt-0.5">directions_run</span>
                                    <span><strong>Aktivitas Fisik:</strong> Olahraga ringan atau hobi luar ruangan yang dilakukan secara mandiri.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-tertiary mt-0.5">handyman</span>
                                    <span><strong>Hobi Motorik:</strong> Aktivitas merakit, memperbaiki, atau menciptakan sesuatu yang membutuhkan fokus tangan dan pikiran.</span>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-auto pt-4 border-t border-surface-variant">
                            <h4 class="text-sm font-bold text-green-700 mb-1 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">check_circle</span> Dampak Positif</h4>
                            <p class="text-[13px] text-on-surface-variant italic">Menghindari burnout dan menjaga performa kognitif tetap prima.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Area 3: Mitigasi Domain Lemah -->
            @php
                $bottomRiasec = collect($result->input_riasec ?? [])->sort()->keys()->take(2)->toArray();
            @endphp
            <div class="bg-[#fff5f5] rounded-2xl border border-error-container shadow-sm overflow-hidden flex flex-col mb-12 relative">
                <div class="absolute -right-10 -top-10 opacity-5 pointer-events-none">
                    <span class="material-symbols-outlined text-[200px]">warning</span>
                </div>
                <div class="p-6 border-b border-error-container bg-error/10 relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-error rounded-lg text-white">
                            <span class="material-symbols-outlined">health_and_safety</span>
                        </div>
                        <h3 class="text-xl font-bold text-error">Mitigasi Domain Lemah</h3>
                    </div>
                    <p class="text-sm text-error/80">Pelatihan minimum agar kelemahan tidak menjadi penghalang.</p>
                </div>
                <div class="p-6 flex flex-col md:flex-row gap-8 relative z-10">
                    <div class="md:w-1/3">
                        <div class="bg-white p-5 rounded-xl border border-error/20 shadow-sm h-full">
                            <h4 class="text-sm font-bold text-error mb-3">Domain Tantangan:</h4>
                            <div class="flex items-center gap-2 mb-4">
                                @foreach($bottomRiasec as $low)
                                    <span class="px-3 py-1.5 bg-error/10 text-error text-xs font-bold rounded-lg border border-error/20">{{ $riasecLabels[$low] ?? $low }}</span>
                                @endforeach
                            </div>
                            <p class="text-[13px] text-on-surface-variant leading-relaxed">
                                <strong>Penjelasan:</strong> Skor rendah pada domain ini menunjukkan area di mana Anda mungkin merasa cepat lelah atau kurang percaya diri. Namun, penguasaan dasar di area ini tetap penting untuk koordinasi profesional.
                            </p>
                        </div>
                    </div>
                    
                    <div class="md:w-2/3 flex flex-col justify-center">
                        <h4 class="text-sm font-bold text-error mb-4 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">healing</span> Jalur Upaya & Antisipasi</h4>
                        <ul class="space-y-4 text-sm text-on-surface-variant mb-6">
                            <li class="flex items-start gap-3">
                                <div class="p-1.5 rounded-full bg-error/10 text-error shrink-0 mt-0.5"><span class="material-symbols-outlined text-[14px]">psychology_alt</span></div>
                                <span>Ikuti pelatihan singkat komunikasi atau manajemen dasar untuk menyeimbangkan profil teknis Anda.</span>
                            </li>
                            <li class="flex items-start gap-3 bg-error/10 p-3.5 rounded-xl border border-error/20 font-medium text-error">
                                <div class="p-1 rounded-full bg-error text-white shrink-0"><span class="material-symbols-outlined text-[14px]">stars</span></div>
                                <span><strong>Saran Strategis:</strong> Fokuslah pada hasil akhir pekerjaan, namun jangan abaikan aspek relasi dan presentasi yang menjadi jembatan kesuksesan ide Anda.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
