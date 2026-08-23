<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Halaman Asesmen - ShiroAsesmen</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#800000", // Maroon
                        accent: "#FFD700",  // Gold
                        surface: "#F7F9FB",
                        "on-surface": "#191C1E",
                        "on-surface-variant": "#4A4455",
                        outline: "#7B7487",
                        "outline-variant": "#CCC3D8",
                        "primary-container": "#FEE2E2", // Light Red/Maroon
                        "secondary-container": "#E9D5FF", // Light Purple
                        "on-primary-container": "#450A0A",
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "1rem",
                        "2xl": "1.5rem",
                        full: "9999px"
                    },
                    fontFamily: {
                        sans: ["Inter", "sans-serif"],
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        window.assessmentData = {
            total: {{ $questions->count() }},
            questions: {!! $questions->values()->toJson() !!}
        };
    </script>
</head>
<body class="bg-surface font-sans text-on-surface h-screen flex flex-col overflow-hidden" 
      x-data="{ 
        currentIdx: 0, 
        total: window.assessmentData.total,
        questions: window.assessmentData.questions,
        answers: {},
        domain: 'umum',
        isLoading: false,
        submitError: null,
        mobileMenuOpen: false,
        showModeModal: {{ empty($mode) ? 'true' : 'false' }},
        selectedMode: 'trial',
        selectMode(mode) {
            window.location.href = '?mode=' + mode;
        },
        get progress() { return this.total > 0 ? Math.round((Object.keys(this.answers).length / this.total) * 100) : 0 },
        isAnswered(id) { return this.answers[id] !== undefined },
        setAnswer(qid, val) { this.answers[qid] = val },
        async submitAssessment() {
            this.isLoading = true;
            this.submitError = null;
            try {
                const csrfToken = document.querySelector('meta[name=csrf-token]').getAttribute('content');
                const urlParams = new URLSearchParams(window.location.search);
                const modeParam = urlParams.get('mode') || 'normal';
                
                const payload = { 
                    answers: this.answers, 
                    domain: this.domain,
                    mode: modeParam 
                };
                
                const response = await fetch('/assessment/run', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                const data = await response.json();
                if (data.success && data.result_id) {
                    window.location.href = '/assessment/result/' + data.result_id;
                } else {
                    this.submitError = data.message || 'Terjadi kesalahan saat memproses asesmen.';
                    this.isLoading = false;
                }
            } catch (err) {
                this.submitError = 'Gagal terhubung ke server. Periksa koneksi internet Anda.';
                this.isLoading = false;
            }
        }
      }">
    
    <!-- TopNavBar -->
    <nav class="sticky top-0 z-50 bg-white/70 backdrop-blur-md border-b border-primary/10 shadow-sm shadow-primary/5 flex justify-between items-center px-6 py-4 w-full">
        <div class="flex items-center gap-2 w-1/3">
            <span class="text-2xl font-black text-primary tracking-tighter">ShiroAsesmen</span>
        </div>
        
        <div class="flex justify-center w-1/3">
            <h1 class="text-lg font-bold text-primary uppercase tracking-widest">Halaman Asesmen</h1>
        </div>

        <div class="flex items-center justify-end gap-6 w-1/3">
            <div class="flex items-center gap-3 pl-4 border-l border-outline-variant/30">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-slate-800">{{ session('user_name') ?? (auth()->user()->name ?? 'Guest User') }}</p>
                    <p class="text-xs text-slate-500">Asesmen Mandiri</p>
                </div>
                <img alt="User" class="w-10 h-10 rounded-full border-2 border-primary/20 shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(session('user_name') ?? (auth()->user()->name ?? 'Guest')) }}&background=800000&color=fff"/>
            </div>
        </div>
    </nav>

    <!-- Mode Selection Modal -->
    <div x-show="showModeModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl mx-4 overflow-hidden p-6 md:p-10 border-t-8 border-primary">
            <div class="flex flex-col items-center mb-8">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-4xl">tune</span>
                </div>
                <h2 class="text-3xl font-black text-primary mb-2 text-center">Pilih Mode Asesmen</h2>
                <p class="text-center text-slate-500 max-w-lg">Pilih metode yang paling sesuai dengan kebutuhan dan waktu Anda saat ini. Mode Normal memberikan akurasi tertinggi.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Trial -->
                <button @click="selectedMode = 'trial'" :class="selectedMode === 'trial' ? 'border-primary bg-primary/5 ring-2 ring-primary/20 scale-[1.02]' : 'border-slate-200 hover:border-primary/50 hover:bg-slate-50'" class="p-6 rounded-2xl border-2 text-left transition-all relative overflow-hidden group h-full flex flex-col shadow-sm">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-primary/10 to-transparent rounded-bl-[40px]"></div>
                    <span class="material-symbols-outlined text-4xl mb-4" :class="selectedMode === 'trial' ? 'text-primary' : 'text-slate-400'">rocket_launch</span>
                    <h3 class="font-black text-xl mb-1" :class="selectedMode === 'trial' ? 'text-primary' : 'text-slate-800'">Mode Trial</h3>
                    <span class="inline-block px-3 py-1 bg-slate-100 text-slate-600 font-bold text-xs rounded-full mb-4 w-fit">20 Pertanyaan</span>
                    <p class="text-sm text-slate-500 leading-relaxed flex-1">Tes kilat untuk mengetahui gambaran dasar karakter Anda dengan cepat.</p>
                    <div class="mt-4 flex items-center text-xs font-bold" :class="selectedMode === 'trial' ? 'text-primary' : 'text-slate-400'">
                        <span class="material-symbols-outlined text-sm mr-1">timer</span> Estimasi: ~3 Menit
                    </div>
                </button>

                <!-- Cepat -->
                <button @click="selectedMode = 'cepat'" :class="selectedMode === 'cepat' ? 'border-accent bg-accent/5 ring-2 ring-accent/20 scale-[1.02]' : 'border-slate-200 hover:border-accent/50 hover:bg-slate-50'" class="p-6 rounded-2xl border-2 text-left transition-all relative overflow-hidden group h-full flex flex-col shadow-sm">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-accent/20 to-transparent rounded-bl-[40px]"></div>
                    <span class="material-symbols-outlined text-4xl mb-4" :class="selectedMode === 'cepat' ? 'text-[#D4AF37]' : 'text-slate-400'">speed</span>
                    <h3 class="font-black text-xl mb-1" :class="selectedMode === 'cepat' ? 'text-[#D4AF37]' : 'text-slate-800'">Mode Cepat</h3>
                    <span class="inline-block px-3 py-1 bg-[#D4AF37]/10 text-[#D4AF37] font-bold text-xs rounded-full mb-4 w-fit">40 Pertanyaan</span>
                    <p class="text-sm text-slate-500 leading-relaxed flex-1">Pilihan optimal dengan keseimbangan antara kecepatan dan akurasi analisis.</p>
                    <div class="mt-4 flex items-center text-xs font-bold" :class="selectedMode === 'cepat' ? 'text-[#D4AF37]' : 'text-slate-400'">
                        <span class="material-symbols-outlined text-sm mr-1">timer</span> Estimasi: ~5 Menit
                    </div>
                </button>

                <!-- Normal -->
                <button @click="selectedMode = 'normal'" :class="selectedMode === 'normal' ? 'border-green-600 bg-green-50 ring-2 ring-green-600/20 scale-[1.02]' : 'border-slate-200 hover:border-green-600/50 hover:bg-slate-50'" class="p-6 rounded-2xl border-2 text-left transition-all relative overflow-hidden group h-full flex flex-col shadow-sm">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-green-500/20 to-transparent rounded-bl-[40px]"></div>
                    <div class="absolute -top-3 -right-3 bg-green-600 text-white text-[10px] font-black uppercase tracking-widest py-1 px-8 rotate-45 shadow-md">Akurat</div>
                    <span class="material-symbols-outlined text-4xl mb-4" :class="selectedMode === 'normal' ? 'text-green-600' : 'text-slate-400'">psychology</span>
                    <h3 class="font-black text-xl mb-1" :class="selectedMode === 'normal' ? 'text-green-600' : 'text-slate-800'">Mode Normal</h3>
                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 font-bold text-xs rounded-full mb-4 w-fit">176 Pertanyaan</span>
                    <p class="text-sm text-slate-500 leading-relaxed flex-1">Analisis mendalam dan komprehensif. Sangat disarankan untuk hasil SPK presisi.</p>
                    <div class="mt-4 flex items-center text-xs font-bold" :class="selectedMode === 'normal' ? 'text-green-600' : 'text-slate-400'">
                        <span class="material-symbols-outlined text-sm mr-1">timer</span> Estimasi: ~15 Menit
                    </div>
                </button>
            </div>

            <div class="flex flex-col items-center border-t border-slate-100 pt-6">
                <button @click="selectMode(selectedMode)" class="px-12 py-4 rounded-xl bg-primary text-white font-black text-lg shadow-xl shadow-primary/20 hover:bg-[#570000] hover:shadow-primary/40 hover:-translate-y-1 transition-all flex items-center gap-2">
                    Lanjutkan Asesmen <span class="material-symbols-outlined">arrow_forward</span>
                </button>
                <p class="text-xs text-slate-400 mt-4">Anda tidak dapat mengubah mode setelah asesmen dimulai.</p>
            </div>
        </div>
    </div>

    <div class="flex flex-1 overflow-hidden relative">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="mobileMenuOpen" 
             @click="mobileMenuOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/40 z-40 md:hidden" style="display:none;"></div>

        <!-- SideNavBar (Question Map) -->
        <aside :class="mobileMenuOpen ? 'flex' : 'hidden md:flex'"
               class="fixed md:relative z-50 md:z-auto inset-y-0 left-0 flex-col p-6 gap-6 w-80 border-r bg-white shadow-2xl md:shadow-none md:bg-white/50 backdrop-blur-sm overflow-y-auto">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Peta Soal</h2>
                <p class="text-xs font-medium uppercase tracking-widest text-slate-500 mt-1">Status Pengerjaan</p>
            </div>
            
            <div class="grid grid-cols-5 gap-2">
                <template x-for="(q, index) in questions" :key="q.id">
                    <button @click="currentIdx = index"
                            :class="{
                                'bg-green-600 text-white border-green-700 shadow-sm': isAnswered(q.id) && currentIdx !== index,
                                'bg-primary text-white shadow-lg shadow-primary/20 ring-2 ring-primary/30 scale-110': currentIdx === index,
                                'bg-white text-slate-400 border-slate-200': !isAnswered(q.id) && currentIdx !== index
                            }"
                            class="w-11 h-11 flex items-center justify-center rounded-xl border text-sm font-bold transition-all">
                        <span x-text="index + 1"></span>
                    </button>
                </template>
            </div>

            <div class="mt-auto p-4 rounded-2xl bg-primary/5 border border-primary/10">
                <div class="flex justify-between text-xs font-bold mb-2">
                    <span class="text-slate-600">Terjawab</span>
                    <span class="text-primary"><span x-text="Object.keys(answers).length"></span> / <span x-text="total"></span></span>
                </div>
                <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                    <div class="bg-primary h-full transition-all duration-500" :style="`width: ${progress}%`"></div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-4 md:p-12 flex flex-col items-center justify-center">
            <div class="w-full max-w-3xl flex flex-col gap-4 md:gap-8">

                <!-- Submit Error Alert -->
                <div x-show="submitError" 
                     x-transition
                     class="flex items-start gap-3 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700"
                     style="display:none;">
                    <span class="material-symbols-outlined text-xl mt-0.5">error</span>
                    <div>
                        <p class="font-bold text-sm">Pengiriman Gagal</p>
                        <p class="text-sm" x-text="submitError"></p>
                    </div>
                </div>
                
                <!-- Progress Indicator -->
                <div class="space-y-3">
                    <div class="flex justify-between items-end">
                        <span class="text-xs font-black text-primary uppercase tracking-[0.2em]">Progress Asesmen</span>
                        <span class="text-xs font-bold text-primary" x-text="progress + '% Selesai'"></span>
                    </div>
                    <div class="w-full bg-white h-3 rounded-full border border-primary/10 overflow-hidden p-0.5">
                        <div class="bg-primary h-full rounded-full shadow-sm shadow-primary/50 transition-all duration-500" :style="`width: ${progress}%`"></div>
                    </div>
                </div>

                <!-- Assessment Card -->
                <div class="glass-card rounded-2xl shadow-xl shadow-primary/5 p-5 md:p-12 border-2 border-primary/20 relative overflow-hidden md:min-h-[400px]">
                    <!-- Decorative background -->
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-accent/10 rounded-full blur-3xl pointer-events-none"></div>

                    <template x-if="questions[currentIdx]">
                        <div class="relative z-10 flex flex-col gap-6 md:gap-12" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                            <!-- Question Header -->
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-[10px] md:text-xs font-black text-primary uppercase tracking-[0.3em] bg-primary/10 px-3 md:px-4 py-1 md:py-1.5 rounded-full" x-text="'Soal Nomor ' + (currentIdx + 1)"></span>
                            </div>

                            <!-- Question Text -->
                            <div class="text-center space-y-2 md:space-y-6">
                                <h2 class="text-lg md:text-3xl font-bold text-on-surface leading-tight" x-text="'&quot;' + questions[currentIdx].text + '&quot;'"></h2>
                                <p class="text-slate-500 text-xs md:text-sm">Pilih satu jawaban yang paling mencerminkan diri Anda.</p>
                            </div>

                            <!-- Answer Options -->
                            <div class="flex flex-row justify-between md:grid md:grid-cols-5 gap-1.5 md:gap-3">
                                <template x-for="val in [1,2,3,4,5]">
                                    <button @click="setAnswer(questions[currentIdx].id, val)"
                                            :class="{
                                                'border-primary bg-primary/5 shadow-md': answers[questions[currentIdx].id] === val,
                                                'border-slate-200 md:border-transparent bg-slate-50 hover:bg-primary/5 hover:border-primary/20': answers[questions[currentIdx].id] !== val
                                            }"
                                            class="flex flex-col items-center justify-start pt-3 pb-2 px-1 md:p-4 rounded-lg md:rounded-xl border md:border-2 transition-all group min-h-[85px] md:min-h-[100px] flex-1">
                                        <div class="w-5 h-5 md:w-6 md:h-6 rounded-full border-2 mb-2 md:mb-3 flex items-center justify-center transition-colors"
                                             :class="answers[questions[currentIdx].id] === val ? 'border-primary' : 'border-slate-300'">
                                            <div class="w-2.5 h-2.5 md:w-3 md:h-3 bg-primary rounded-full" x-show="answers[questions[currentIdx].id] === val"></div>
                                        </div>
                                        <span class="text-[8px] md:text-[10px] font-black uppercase text-center tracking-tighter leading-tight break-words"
                                              :class="answers[questions[currentIdx].id] === val ? 'text-primary' : 'text-slate-500'"
                                              x-text="['Sangat Tidak Setuju', 'Tidak Setuju', 'Biasa Saja', 'Setuju', 'Sangat Setuju'][val-1]">
                                        </span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Footer Navigation -->
                <div class="flex items-center justify-between mt-2 md:mt-0 gap-2">
                    <button @click="if(currentIdx > 0) currentIdx--" 
                            :disabled="currentIdx === 0"
                            class="group px-4 md:px-8 py-2.5 md:py-3.5 rounded-lg md:rounded-xl bg-secondary-container/50 text-primary font-bold hover:bg-secondary-container transition-all flex items-center gap-1 md:gap-3 border border-primary/10 disabled:opacity-30 disabled:cursor-not-allowed text-xs md:text-base">
                        <span class="material-symbols-outlined text-lg md:text-xl group-hover:-translate-x-1 transition-transform">arrow_back</span>
                        <span class="hidden md:inline">Sebelumnya</span>
                        <span class="md:hidden">Back</span>
                    </button>
                    
                    <div class="flex gap-2 md:gap-4">
                        <button x-show="currentIdx < total - 1"
                                @click="currentIdx++"
                                class="group px-6 md:px-10 py-2.5 md:py-3.5 rounded-lg md:rounded-xl bg-primary text-white font-bold hover:shadow-xl hover:shadow-primary/30 transition-all flex items-center gap-1 md:gap-3 text-xs md:text-base">
                            <span class="hidden md:inline">Selanjutnya</span>
                            <span class="md:hidden">Next</span>
                            <span class="material-symbols-outlined text-lg md:text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>

                        <button x-show="currentIdx === total - 1"
                                @click="submitAssessment()"
                                :disabled="Object.keys(answers).length < total || isLoading"
                                class="group px-6 md:px-10 py-2.5 md:py-3.5 rounded-lg md:rounded-xl bg-green-600 text-white font-bold hover:bg-green-700 hover:shadow-xl hover:shadow-green-600/30 transition-all flex items-center gap-1 md:gap-3 disabled:opacity-50 disabled:cursor-not-allowed text-xs md:text-base">
                            <template x-if="!isLoading">
                                <span class="flex items-center gap-1 md:gap-3">
                                    <span class="hidden md:inline">Kirim Jawaban</span>
                                    <span class="md:hidden">Kirim</span>
                                    <span class="material-symbols-outlined text-lg md:text-xl">task_alt</span>
                                </span>
                            </template>
                            <template x-if="isLoading">
                                <span class="flex items-center gap-1 md:gap-3">
                                    <svg class="animate-spin h-4 w-4 md:h-5 md:w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    <span class="hidden md:inline">Memproses...</span>
                                </span>
                            </template>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Mobile Nav Toggle -->
    <button @click="mobileMenuOpen = !mobileMenuOpen"
            class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-primary text-white rounded-full shadow-2xl z-50 flex items-center justify-center transition-transform hover:scale-110 active:scale-95">
        <span class="material-symbols-outlined" x-text="mobileMenuOpen ? 'close' : 'grid_view'">grid_view</span>
    </button>

</body>
</html>
