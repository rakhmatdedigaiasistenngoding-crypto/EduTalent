<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identitas Pengguna | ShiroAsesmen</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #A00000; /* UTI Red */
            --secondary: #D4AF37; /* UTI Gold */
            --accent: #FFD700; /* Bright Gold */
            --bg-light: #F0F2F5;
            --card-bg: #FFFFFF;
            --text-main: #1A1A1A;
            --text-muted: #64748B;
            --input-bg: #F8FAFC;
            --border: #E2E8F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(160, 0, 0, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 100% 100%, rgba(212, 175, 55, 0.05) 0%, transparent 40%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            color: var(--text-main);
        }

        .login-card {
            background: var(--card-bg);
            padding: 2.5rem;
            border-radius: 24px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border);
            border-top: 6px solid var(--primary); /* Accent line */
            text-align: center;
            animation: fadeIn 0.8s ease-out;
            position: relative;
            overflow: hidden;
        }

        /* Decorative Gold Corner */
        .login-card::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 100px;
            height: 100px;
            background: var(--secondary);
            transform: rotate(45deg);
            opacity: 0.1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header-content {
            margin-bottom: 2rem;
        }

        .uti-logo {
            width: 80px;
            height: auto;
            margin-bottom: 0.75rem;
        }

        .university-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.25rem;
        }

        .logo {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
            color: var(--primary);
            letter-spacing: -1px;
            line-height: 1.1;
        }

        .subtitle {
            font-weight: 400;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            font-size: 0.95rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            text-align: left;
        }

        .form-group {
            margin-bottom: 1.25rem;
            text-align: left;
        }

        .full-width {
            grid-column: span 2;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.25rem;
            transition: color 0.3s ease;
        }

        input, select {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 3rem;
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            color: var(--text-main);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        select {
            appearance: none;
            cursor: pointer;
        }

        .input-wrapper .arrow {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--secondary);
            background: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
        }

        input:focus + .icon, select:focus + .icon {
            color: var(--primary);
        }

        .dynamic-fields {
            display: none;
            grid-column: span 2;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 0.5rem;
            padding: 1.5rem;
            background: rgba(212, 175, 55, 0.03);
            border-radius: 16px;
            border: 1px dashed var(--secondary);
        }

        .dynamic-fields.active {
            display: grid;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-submit {
            width: 100%;
            padding: 1.1rem;
            background: linear-gradient(135deg, var(--primary) 0%, #800000 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 15px -3px rgba(160, 0, 0, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(160, 0, 0, 0.4);
            filter: brightness(1.1);
        }

        .footer-text {
            margin-top: 2rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .error-msg {
            color: #E11D48;
            font-size: 0.8rem;
            margin-top: 0.4rem;
            font-weight: 500;
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .full-width, .dynamic-fields {
                grid-column: span 1;
            }
            .dynamic-fields {
                grid-template-columns: 1fr;
            }
        }

        .error-msg {
            color: #ff4d4d;
            font-size: 0.8rem;
            margin-top: 0.4rem;
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .full-width, .dynamic-fields {
                grid-column: span 1;
            }
            .dynamic-fields {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="header-content">
            <img src="{{ asset('assets/Teknokrat/logo UNIVERSITASTEKNOKRAT.png') }}" alt="Logo UTI" class="uti-logo">
            <h2 class="university-name">Universitas Teknokrat Indonesia</h2>
            <h1 class="logo">SHIRO ASESMEN</h1>
        </div>
        <p class="subtitle">Lengkapi identitas Anda untuk memulai asesmen</p>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-grid">
                <!-- Nama Lengkap -->
                <div class="form-group full-width">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined icon">person</span>
                        <input type="text" id="name" name="name" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required autofocus>
                    </div>
                    @error('name') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <!-- WhatsApp -->
                <div class="form-group">
                    <label for="whatsapp">Nomor WhatsApp</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined icon">call</span>
                        <input type="tel" id="whatsapp" name="whatsapp" placeholder="Contoh: 08123456789" value="{{ old('whatsapp') }}" required>
                    </div>
                    @error('whatsapp') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined icon">mail</span>
                        <input type="email" id="email" name="email" placeholder="Contoh: nama@email.com" value="{{ old('email') }}" required>
                    </div>
                    @error('email') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div class="form-group full-width">
                    <label for="identity_type">Status Saat Ini</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined icon">badge</span>
                        <select id="identity_type" name="identity_type" onchange="toggleDynamicFields(this.value)" required>
                            <option value="" disabled {{ old('identity_type') ? '' : 'selected' }}>- Pilih Status -</option>
                            <option value="anonymous" {{ old('identity_type') == 'anonymous' ? 'selected' : '' }}>Umum / Lainnya</option>
                            <option value="student" {{ old('identity_type') == 'student' ? 'selected' : '' }}>Siswa (Sekolah)</option>
                            <option value="university_student" {{ old('identity_type') == 'university_student' ? 'selected' : '' }}>Mahasiswa (Kuliah)</option>
                            <option value="employee" {{ old('identity_type') == 'employee' ? 'selected' : '' }}>Pekerja / Profesional</option>
                        </select>
                        <span class="material-symbols-outlined arrow">expand_more</span>
                    </div>
                    @error('identity_type') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <!-- Dynamic Fields: Siswa -->
                <div id="fields_student" class="dynamic-fields {{ old('identity_type') == 'student' ? 'active' : '' }}">
                    <div class="form-group">
                        <label for="school_level">Jenjang</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined icon">layers</span>
                            <select id="school_level" name="school_level" onchange="toggleSmkField(this.value)">
                                <option value="" disabled {{ old('school_level') ? '' : 'selected' }}>- Pilih Jenjang -</option>
                                <option value="SMP" {{ old('school_level') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                                <option value="SMA" {{ old('school_level') == 'SMA' ? 'selected' : '' }}>SMA / Sederajat</option>
                                <option value="SMK" {{ old('school_level') == 'SMK' ? 'selected' : '' }}>SMK / Sederajat</option>
                            </select>
                            <span class="material-symbols-outlined arrow">expand_more</span>
                        </div>
                    </div>
                    {{-- Jurusan SMK: hanya tampil jika jenjang = SMK --}}
                    <div class="form-group" id="smk_major_field" style="display:none;">
                        <label for="school_major">Jurusan / Kompetensi Keahlian (SMK)</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined icon">construction</span>
                            <input type="text" id="school_major" name="school_major" placeholder="Contoh: Teknik Komputer Jaringan" value="{{ old('school_major') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="school_name">Nama Sekolah</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined icon">school</span>
                            <input type="text" id="school_name" name="school_name" placeholder="Contoh: SMKN 2 Bandarlampung" value="{{ old('school_name') }}">
                        </div>
                    </div>
                </div>

                <!-- Dynamic Fields: Mahasiswa -->
                <div id="fields_university_student" class="dynamic-fields {{ old('identity_type') == 'university_student' ? 'active' : '' }}">
                    <div class="form-group">
                        <label for="major">Program Studi</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined icon">account_tree</span>
                            <input type="text" id="major" name="major" placeholder="Contoh: Teknik Informatika" value="{{ old('major') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="university_name">Nama Kampus</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined icon">apartment</span>
                            <input type="text" id="university_name" name="university_name" placeholder="Contoh: Universitas Teknokrat Indonesia" value="{{ old('university_name') }}">
                        </div>
                    </div>
                </div>

                <!-- Dynamic Fields: Pekerja -->
                <div id="fields_employee" class="dynamic-fields {{ old('identity_type') == 'employee' ? 'active' : '' }}">
                    <div class="form-group">
                        <label for="job_title">Profesi / Bidang</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined icon">work</span>
                            <input type="text" id="job_title" name="job_title" placeholder="Contoh: Software Engineer" value="{{ old('job_title') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name">Nama Perusahaan</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined icon">business</span>
                            <input type="text" id="company_name" name="company_name" placeholder="Contoh: PT. Maju Bersama" value="{{ old('company_name') }}">
                        </div>
                    </div>
                </div>
                
                <div class="full-width" style="margin-top: 1rem; border-top: 1px dashed var(--border); padding-top: 1rem;">
                    <p style="font-weight: 700; color: var(--primary); margin-bottom: 1rem; font-size: 0.9rem;">INFORMASI TAMBAHAN</p>
                </div>

                <!-- Evaluasi Diri: Pengenalan Karakter -->
                <div class="form-group full-width">
                    <label for="self_awareness">Seberapa dalam Anda mengenal karakter dan minat diri Anda sendiri?</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined icon">psychology_alt</span>
                        <select id="self_awareness" name="self_awareness" required>
                            <option value="" disabled {{ old('self_awareness') ? '' : 'selected' }}>- Pilih Jawaban -</option>
                            <option value="Sangat mengenal" {{ old('self_awareness') == 'Sangat mengenal' ? 'selected' : '' }}>Sangat mengenal</option>
                            <option value="Cukup mengenal" {{ old('self_awareness') == 'Cukup mengenal' ? 'selected' : '' }}>Cukup mengenal</option>
                            <option value="Kurang mengenal" {{ old('self_awareness') == 'Kurang mengenal' ? 'selected' : '' }}>Kurang mengenal</option>
                            <option value="Tidak mengenal" {{ old('self_awareness') == 'Tidak mengenal' ? 'selected' : '' }}>Tidak mengenal</option>
                        </select>
                        <span class="material-symbols-outlined arrow">expand_more</span>
                    </div>
                </div>

                <!-- Pengalaman Asesmen -->
                <div class="form-group full-width">
                    <label for="has_taken_assessment">Apakah sudah pernah mengikuti asesmen mengenai Minat/Bakat/Karakter?</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined icon">assignment_turned_in</span>
                        <select id="has_taken_assessment" name="has_taken_assessment" required>
                            <option value="" disabled {{ old('has_taken_assessment') ? '' : 'selected' }}>- Pilih Jawaban -</option>
                            <option value="Pernah" {{ old('has_taken_assessment') == 'Pernah' ? 'selected' : '' }}>Pernah</option>
                            <option value="Belum pernah" {{ old('has_taken_assessment') == 'Belum pernah' ? 'selected' : '' }}>Belum pernah</option>
                        </select>
                        <span class="material-symbols-outlined arrow">expand_more</span>
                    </div>
                </div>

                <!-- Pemilihan Jurusan -->
                <div class="form-group full-width">
                    <label for="major_decided">Apakah sudah mengetahui Jurusan apa yang dipilih saat kuliah?</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined icon">account_balance</span>
                        <select id="major_decided" name="major_decided" required>
                            <option value="" disabled {{ old('major_decided') ? '' : 'selected' }}>- Pilih Jawaban -</option>
                            <option value="Sudah" {{ old('major_decided') == 'Sudah' ? 'selected' : '' }}>Sudah</option>
                            <option value="Belum" {{ old('major_decided') == 'Belum' ? 'selected' : '' }}>Belum</option>
                            <option value="Ragu-ragu" {{ old('major_decided') == 'Ragu-ragu' ? 'selected' : '' }}>Ragu-ragu</option>
                        </select>
                        <span class="material-symbols-outlined arrow">expand_more</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">Lanjutkan</button>
        </form>

        <p class="footer-text">Data Anda akan digunakan untuk menyesuaikan rekomendasi hasil asesmen.</p>
    </div>

    <script>
        function toggleDynamicFields(type) {
            document.querySelectorAll('.dynamic-fields').forEach(el => {
                el.classList.remove('active');
            });
            const target = document.getElementById('fields_' + type);
            if (target) target.classList.add('active');

            // Reset SMK field visibility when switching status
            const smkField = document.getElementById('smk_major_field');
            if (smkField) smkField.style.display = 'none';
        }

        function toggleSmkField(level) {
            const smkField = document.getElementById('smk_major_field');
            if (smkField) {
                smkField.style.display = (level === 'SMK') ? 'block' : 'none';
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            const currentType = document.getElementById('identity_type').value;
            toggleDynamicFields(currentType);

            // Restore SMK field if old value was SMK
            const schoolLevel = document.getElementById('school_level');
            if (schoolLevel) toggleSmkField(schoolLevel.value);
        });
    </script>
</body>
</html>

