<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShiroAsesmen - Input Data Penilaian</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --bg-light: #F8FAFC;
            --text-main: #1E293B;
            --text-muted: #64748B;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-light); color: var(--text-main); line-height: 1.6; }
        .container { max-width: 800px; margin: 0 auto; padding: 2rem 1rem; }
        
        header { text-align: center; margin-bottom: 3rem; }
        h1 { font-size: 2.5rem; font-weight: 800; color: var(--primary); letter-spacing: -0.025em; }
        .subtitle { color: var(--text-muted); font-size: 1.1rem; margin-top: 0.5rem; }

        .assessment-card { background: white; border-radius: 1.25rem; padding: 2rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: 1px solid #E2E8F0; }
        .section-title { font-size: 1.5rem; font-weight: 700; color: var(--primary); margin: 2rem 0 1.5rem; border-bottom: 2px solid #F1F5F9; padding-bottom: 0.5rem; }
        
        .question-item { background: #F8FAFC; padding: 1.5rem; border-radius: 1rem; border: 1px solid #F1F5F9; margin-bottom: 1.5rem; transition: all 0.2s ease; }
        .question-item:hover { border-color: var(--primary); transform: translateY(-2px); }
        .question-text { font-weight: 600; margin-bottom: 1.25rem; color: var(--text-main); font-size: 1.05rem; }

        .options-group { display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; max-width: 500px; margin: 0 auto; }
        .option-label { display: flex; flex-direction: column; align-items: center; gap: 0.25rem; cursor: pointer; }
        .option-label input { width: 1.5rem; height: 1.5rem; cursor: pointer; accent-color: var(--primary); }
        .option-val { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); }
        .hint-text { font-size: 0.75rem; color: var(--text-muted); font-weight: 600; width: 80px; text-align: center; }

        .submit-btn { 
            width: 100%; padding: 1.25rem; background-color: var(--primary); color: white; border: none; 
            border-radius: 0.75rem; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease;
            display: flex; justify-content: center; align-items: center; gap: 0.75rem; margin-top: 2rem;
        }
        .submit-btn:hover { background-color: var(--primary-dark); transform: scale(1.01); }
        .submit-btn:disabled { background-color: #94A3B8; cursor: not-allowed; transform: none; }

        .error-banner { background: #FEE2E2; color: #DC2626; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: none; align-items: center; gap: 0.5rem; border: 1px solid #FECACA; }
        
        .loader { width: 20px; height: 20px; border: 3px solid #FFF; border-bottom-color: transparent; border-radius: 50%; display: inline-block; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        .results-section { display: none; margin-top: 3rem; }
        .result-main-card { background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); border-radius: 1.5rem; padding: 2.5rem; color: white; margin-bottom: 1.5rem; box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.25); }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="flex: 1; text-align: left;">
                    @if(session('user_name'))
                        <span style="font-weight: 600; color: var(--text-main); font-size: 1.1rem;">Halo, {{ session('user_name') }}</span>
                    @endif
                </div>
                <h1>ShiroAsesmen</h1>
                <div style="flex: 1; text-align: right;">
                    <a href="/assessment/history" style="text-decoration: none; font-weight: 600; color: var(--primary);">Riwayat →</a>
                </div>
            </div>
            <p class="subtitle">Analisis Karakter & Rekomendasi Profesi Masa Depan</p>
        </header>

        <div id="error-banner" class="error-banner">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span id="error-text"></span>
        </div>

        <div class="assessment-card">
            @php
                $dimensions = [
                    'trait' => '1. Karakter Dasar (Trait)',
                    'riasec' => '2. Minat Pekerjaan (RIASEC)',
                    'environment' => '3. Lingkungan Kerja (Environment)'
                ];
                $totalQuestions = $questions->count();
            @endphp

            @foreach($dimensions as $dim => $label)
                <h2 class="section-title">{{ $label }}</h2>
                @foreach($questions->where('dimension', $dim) as $question)
                    <div class="question-item">
                        <p class="question-text">{{ $loop->iteration }}. {{ $question->text }}</p>
                        <div class="options-group">
                            <span class="hint-text">Sangat Tidak Sesuai</span>
                            <div style="display: flex; gap: 1rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="option-label">
                                        <input type="radio" name="q{{ $question->id }}" value="{{ $i }}" data-qid="{{ $question->id }}">
                                        <span class="option-val">{{ $i }}</span>
                                    </label>
                                @endfor
                            </div>
                            <span class="hint-text">Sangat Sesuai</span>
                        </div>
                    </div>
                @endforeach
            @endforeach

            <h2 class="section-title">4. Pilihan Bidang (Opsional)</h2>
            <div class="question-item">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Filter Berdasarkan Bidang</label>
                <select id="domain-select" style="width: 100%; padding: 0.85rem; border-radius: 0.75rem; border: 1px solid #E2E8F0; font-family: inherit;">
                    <option value="">Semua Bidang</option>
                    <option value="teknologi">Teknologi & IT</option>
                    <option value="bisnis">Bisnis & Keuangan</option>
                    <option value="kreatif">Seni & Kreatif</option>
                    <option value="sosial">Sosial & Pendidikan</option>
                    <option value="kesehatan">Kesehatan</option>
                </select>
            </div>

            <button id="submit-btn" class="submit-btn" onclick="submitForm()">
                <span id="btn-text">Analisis Karakter & Cari Profesi →</span>
            </button>
            <p id="progress-text" style="text-align: center; margin-top: 1rem; font-size: 0.875rem; color: var(--text-muted);">
                Progres: <span id="answered-count">0</span> dari {{ $totalQuestions }} pertanyaan dijawab
            </p>
        </div>

        <!-- Result Section (Vanilla) -->
        <div id="results-view" class="results-section">
            <h2 class="section-title">Hasil Rekomendasi Anda</h2>
            <div id="result-container"></div>
            <div style="text-align: center; margin-top: 2rem;">
                <button onclick="location.reload()" class="submit-btn" style="width: auto; background: #F1F5F9; color: var(--text-main); display: inline-block; padding: 0.75rem 2rem;">
                    ← Ulangi Tes
                </button>
            </div>
        </div>
    </div>

    <script>
        const totalQs = {{ $totalQuestions }};
        const radios = document.querySelectorAll('input[type="radio"]');
        const answeredSpan = document.getElementById('answered-count');
        
        // Update progress counter
        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                const uniqueAnswered = new Set();
                document.querySelectorAll('input[type="radio"]:checked').forEach(r => {
                    uniqueAnswered.add(r.getAttribute('name'));
                });
                answeredSpan.innerText = uniqueAnswered.size;
            });
        });

        async function submitForm() {
            const btn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const errorBanner = document.getElementById('error-banner');
            const errorText = document.getElementById('error-text');
            
            // Collect answers
            const answers = {};
            const checked = document.querySelectorAll('input[type="radio"]:checked');
            checked.forEach(r => {
                const qid = r.getAttribute('data-qid');
                answers[qid] = parseInt(r.value);
            });

            if (Object.keys(answers).length < totalQs) {
                alert('Mohon lengkapi semua jawaban (' + Object.keys(answers).length + '/' + totalQs + ')');
                return;
            }

            // Start Loading
            btn.disabled = true;
            btnText.innerHTML = '<span class="loader"></span> Memproses Analisis...';
            errorBanner.style.display = 'none';

            try {
                const response = await fetch('/assessment/run', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        answers: answers,
                        domain: document.getElementById('domain-select').value
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    renderResults(data.results);
                    document.getElementById('results-view').style.display = 'block';
                    document.getElementById('results-view').scrollIntoView({ behavior: 'smooth' });
                    btnText.innerText = '✔ Berhasil';
                } else {
                    throw new Error(data.message || 'Gagal memproses data');
                }
            } catch (err) {
                errorBanner.style.display = 'flex';
                errorText.innerText = 'Error: ' + err.message;
                btn.disabled = false;
                btnText.innerText = 'Coba Lagi →';
            }
        }

        function renderResults(results) {
            const container = document.getElementById('result-container');
            let html = `
                <div class="result-main-card">
                    <span style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">⭐ Rekomendasi Utama</span>
                    <h2 style="font-size: 2rem; font-weight: 800; margin: 1rem 0;">${results[0].name}</h2>
                    <p style="opacity: 0.9; margin-bottom: 1.5rem;">Karakter Anda sangat cocok dengan profesi ini dengan skor kecocokan ${(results[0].score * 100).toFixed(1)}%.</p>
                </div>
            `;
            
            if (results.length > 1) {
                html += '<h3 style="margin: 2rem 0 1rem; font-weight: 700;">Opsi Profesi Lainnya:</h3><div style="display: grid; gap: 1rem;">';
                for (let i = 1; i < results.length; i++) {
                    html += `
                        <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="font-weight: 700;">${results[i].name}</h4>
                                <p style="font-size: 0.875rem; color: var(--text-muted);">Kecocokan: ${(results[i].score * 100).toFixed(1)}%</p>
                            </div>
                            <span style="color: var(--primary); font-weight: 700;">Match →</span>
                        </div>
                    `;
                }
                html += '</div>';
            }
            container.innerHTML = html;
        }
    </script>
</body>
</html>
