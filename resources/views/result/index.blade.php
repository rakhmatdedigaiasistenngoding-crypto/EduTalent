<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Asesmen - ShiroAsesmen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4F46E5;
            --bg: #F9FAFB;
            --card-bg: #FFFFFF;
            --text-main: #111827;
            --text-muted: #6B7280;
            --border: #E5E7EB;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg); color: var(--text-main); line-height: 1.5; padding: 2rem 1rem; }
        .container { max-width: 800px; margin: 0 auto; }
        
        header { margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center; }
        h1 { font-size: 1.75rem; font-weight: 700; }

        .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; transition: all 0.2s; cursor: pointer; font-size: 0.875rem; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-outline { background: white; border: 1px solid var(--border); color: var(--text-main); }
        .btn-outline:hover { background: #F8FAFC; }

        .history-card { background: var(--card-bg); border-radius: 1rem; border: 1px solid var(--border); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        
        .history-item { display: flex; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); transition: background 0.2s; text-decoration: none; color: inherit; }
        .history-item:last-child { border-bottom: none; }
        .history-item:hover { background: #F8FAFC; }

        .item-info { flex: 1; }
        .item-date { font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.25rem; }
        .item-title { font-weight: 600; font-size: 1rem; margin-bottom: 0.125rem; }
        .item-subtitle { font-size: 0.8125rem; color: var(--text-muted); }

        .item-score { text-align: right; padding-left: 1rem; }
        .score-val { font-size: 1.125rem; font-weight: 700; color: var(--primary); }
        .score-label { font-size: 0.6875rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; }

        /* Empty State */
        .empty-state { text-align: center; padding: 4rem 2rem; }
        .empty-icon { width: 64px; height: 64px; background: #EEF2FF; color: var(--primary); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
        .empty-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; }
        .empty-desc { color: var(--text-muted); margin-bottom: 2rem; font-size: 0.9375rem; max-width: 320px; margin-left: auto; margin-right: auto; }

        /* Alert */
        .alert { padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; font-size: 0.875rem; display: flex; align-items: center; gap: 0.75rem; }
        .alert-error { background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; }

        .pagination { margin-top: 2rem; display: flex; justify-content: center; }
    </style>
</head>
<body>
    <div class="container">
        @if(session('error'))
            <div class="alert alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                {{ session('error') }}
            </div>
        @endif

        <header>
            <div>
                <a href="/assessment" style="font-size: 0.875rem; color: var(--text-muted); text-decoration: none; display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0.25rem;">
                    ← Kembali
                </a>
                <h1>Riwayat Asesmen</h1>
            </div>
            <a href="/assessment" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                Asesmen Baru
            </a>
        </header>

        <div class="history-card">
            @if($results->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><line x1="10" y1="9" x2="8" y2="9"></line></svg>
                    </div>
                    <h2 class="empty-title">Belum Ada Riwayat</h2>
                    <p class="empty-desc">Anda belum pernah melakukan asesmen karakter. Mulailah sekarang untuk menemukan profesi impian Anda.</p>
                    <a href="/assessment" class="btn btn-primary" style="padding: 0.75rem 2rem;">Mulai Asesmen Pertama</a>
                </div>
            @else
                @foreach($results as $item)
                    <a href="{{ route('assessment.show', $item->id) }}" class="history-item">
                        <div class="item-info">
                            <div class="item-date">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</div>
                            <div class="item-title">
                                {{ $item->result_top_n[0]['name'] ?? 'Hasil Asesmen' }}
                            </div>
                            <div class="item-subtitle">
                                Tipe: {{ ucfirst($item->identity->identity_type ?? 'Guest') }} • Mode: {{ ucfirst($item->mode) }}
                            </div>
                        </div>
                        <div class="item-score">
                            <div class="score-val">{{ number_format(($item->top_score ?? 0) * 100, 1) }}%</div>
                            <div class="score-label">Match Score</div>
                        </div>
                        <div style="margin-left: 1.5rem; color: var(--border);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>

        @if($results->hasPages())
            <div class="pagination">
                {{ $results->links() }}
            </div>
        @endif

        <footer style="margin-top: 3rem; text-align: center; font-size: 0.875rem; color: var(--text-muted);">
            &copy; 2026 ShiroAsesmen - Rakhmat Dedi G - EduProject
        </footer>
    </div>
</body>
</html>
