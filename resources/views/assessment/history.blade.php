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

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            padding: 2rem 1rem;
        }

        .container { max-width: 800px; margin: 0 auto; }

        header { margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; }
        h1 { font-size: 1.5rem; font-weight: 700; }
        
        .badge {
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 9999px;
            font-weight: 600;
        }
        .badge-guest { background: #FEF3C7; color: #92400E; }
        .badge-member { background: #D1FAE5; color: #065F46; }

        .history-card {
            background: var(--card-bg);
            border-radius: 1rem;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .history-item {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.2s;
        }
        .history-item:last-child { border-bottom: none; }
        .history-item:hover { background: #F8FAFC; }

        .item-info { flex: 1; }
        .item-date { font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem; }
        .item-title { font-size: 1.125rem; font-weight: 600; }
        .item-domain { font-size: 0.75rem; color: var(--primary); font-weight: 500; margin-top: 0.25rem; }

        .item-score { text-align: right; }
        .score-val { font-size: 1.25rem; font-weight: 700; color: #10B981; }
        .score-label { font-size: 0.75rem; color: var(--text-muted); }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            color: var(--text-muted);
        }

        .btn-back {
            display: inline-block;
            margin-top: 2rem;
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.875rem;
        }

        .pagination-container {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div>
                <h1>Riwayat Asesmen</h1>
                <p style="font-size: 0.875rem; color: var(--text-muted);">Daftar hasil analisis karakter Anda sebelumnya</p>
            </div>
            <div>
                @if(auth()->check())
                    <span class="badge badge-member">Mode: Member • Sumber: Account</span>
                @else
                    <span class="badge badge-guest">Mode: Guest • Sumber: Session</span>
                @endif
            </div>
        </header>

        <div class="history-card">
            @if($history->isEmpty())
                <div class="empty-state">
                    <p>Belum ada riwayat asesmen yang tersimpan.</p>
                    <a href="/assessment" class="btn-back">Mulai Asesmen Sekarang →</a>
                </div>
            @else
                @foreach($history as $item)
                    @php
                        // Guard penarikan data top_n agar anti-error
                        $top = $item->result_top_n[0] ?? null;
                    @endphp
                    <div class="history-item">
                        <div class="item-info">
                            <div class="item-date">{{ $item->created_at->format('d M Y H:i') }}</div>
                            <div class="item-title">
                                <a href="{{ route('assessment.show', $item->id) }}" style="text-decoration: none; color: inherit;">
                                    {{ $top['name'] ?? '-' }}
                                </a>
                            </div>
                            <div class="item-domain">{{ $item->domain ?? 'Semua Bidang' }}</div>
                        </div>
                        <div class="item-score">
                            <div class="score-val">{{ number_format($item->top_score, 3) }}</div>
                            <div class="score-label">Match Score</div>
                            <a href="{{ route('assessment.show', $item->id) }}" style="font-size: 0.75rem; color: var(--primary); text-decoration: none; margin-top: 4px; display: block;">Detail →</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @if($history->hasPages())
            <div class="pagination-container">
                {{ $history->links() }}
            </div>
        @endif

        <div style="text-align: center;">
            <a href="/assessment" class="btn-back">← Kembali ke Form Asesmen</a>
        </div>
    </div>
</body>
</html>
