# Strict Compliance Rules — EduTalent

## TABEL KODE TERKUNCI (LOCKED CODE)

File dan baris berikut DILARANG dimodifikasi tanpa izin eksplisit dari user.

| Path | Status | Alasan Dikunci |
|---|---|---|
| `app/Services/EngineService.php` — Bobot PM (0.7/0.3) & GAP Table | **LOCKED** | Bobot telah divalidasi berdasarkan metodologi SPK |
| `database/migrations/*` yang sudah dijalankan | **LOCKED** | Modifikasi akan merusak data produksi |
| `database/seeders/QuestionSeeder.php` | **LOCKED** | 176 soal IRT telah divalidasi psikometrik |

## VARIABEL ENV YANG TIDAK BOLEH HARDCODE

DILARANG menulis nilai-nilai berikut langsung di kode PHP/Blade:
- `GEMINI_API_KEY`
- `GOOGLE_DRIVE_CLIENT_SECRET`
- `GOOGLE_DRIVE_REFRESH_TOKEN`
- `APP_KEY`

Selalu gunakan `env('NAMA_KEY')` atau `config('nama.key')`.

## LARANGAN UMUM

1. DILARANG menggunakan `dd()` atau `dump()` di kode produksi.
2. DILARANG menyimpan kredensial API ke dalam Git commit.
3. DILARANG mengubah namespace `App\` tanpa refaktor penuh.
4. DILARANG memodifikasi file `vendor/` secara langsung.
