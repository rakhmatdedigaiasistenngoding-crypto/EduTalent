<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Identity;
use App\Models\AssessmentProfile;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Tampilan form login / input identitas.
     * Jika user sudah pernah mengisi, tampilkan data lama (sekali saja di awal).
     */
    public function showLoginForm()
    {
        // Jika sudah ada profil di session, langsung redirect ke asesmen
        if (Session::has('user_name') && Session::has('identity_session_id')) {
            return redirect('/assessment');
        }

        return view('auth.login');
    }

    /**
     * Memproses input identitas dan menyimpannya ke session + DB.
     */
    public function handleLogin(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:255|min:2',
            'whatsapp'             => 'required|string|max:20',
            'email'                => 'required|email|max:255',
            'identity_type'        => 'required|in:anonymous,student,university_student,employee',
            'school_level'         => 'nullable|string|in:SMP,SMA,SMK',
            'school_major'         => 'nullable|string|max:255',
            'school_name'          => 'nullable|string|max:255',
            'major'                => 'nullable|string|max:255',
            'university_name'      => 'nullable|string|max:255',
            'job_title'            => 'nullable|string|max:255',
            'company_name'         => 'nullable|string|max:255',
            'self_awareness'       => 'required|in:Sangat mengenal,Cukup mengenal,Kurang mengenal,Tidak mengenal',
            'has_taken_assessment' => 'required|in:Pernah,Belum pernah',
            'major_decided'        => 'required|in:Sudah,Belum,Ragu-ragu',
        ]);

        $sessionId = Session::getId();

        // ──────────────────────────────────────────────────────────
        // 1. Simpan / update Identity (tabel identities)
        // ──────────────────────────────────────────────────────────
        $metadata = [
            'whatsapp'   => $request->whatsapp,
            'email'      => $request->email,
            'source'     => 'login_form',
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
            'survey' => [
                'self_awareness'       => $request->self_awareness,
                'has_taken_assessment' => $request->has_taken_assessment,
                'major_decided'        => $request->major_decided,
            ],
        ];

        // Data kondisi saat ini per tipe identitas
        if ($request->identity_type === 'student') {
            $metadata['student_info'] = [
                'school_level' => $request->school_level,
                'school_major' => $request->school_major, // khusus SMK
                'school_name'  => $request->school_name,
            ];
        } elseif ($request->identity_type === 'university_student') {
            $metadata['university_info'] = [
                'major'           => $request->major,
                'university_name' => $request->university_name,
            ];
        } elseif ($request->identity_type === 'employee') {
            $metadata['employee_info'] = [
                'job_title'    => $request->job_title,
                'company_name' => $request->company_name,
            ];
        }

        $identityData = [
            'name'          => $request->name,
            'identity_type' => $request->identity_type,
            'metadata'      => $metadata,
            'status'        => 'active',
        ];

        $identity = Identity::where('session_id', $sessionId)->first();
        if (!$identity) {
            $identityData['session_id'] = $sessionId;
            $identity = Identity::create($identityData);
        } else {
            $identity->update($identityData);
        }

        // ──────────────────────────────────────────────────────────
        // 2. Simpan / update AssessmentProfile (tabel assessment_profiles)
        // ──────────────────────────────────────────────────────────
        $profileData = [
            'session_key'          => $sessionId,
            'name'                 => $request->name,
            'whatsapp'             => $request->whatsapp,
            'email'                => $request->email,
            'status'               => $this->mapIdentityTypeToStatus($request->identity_type),
            'school_level'         => $request->school_level,
            'school_major'         => $request->school_major,
            'school_name'          => $request->school_name,
            'college_major'        => $request->major,
            'college_name'         => $request->university_name,
            'work_field'           => $request->job_title,
            'company_name'         => $request->company_name,
            'self_awareness'       => $request->self_awareness,
            'has_taken_assessment' => $request->has_taken_assessment,
            'major_decided'        => $request->major_decided,
        ];

        AssessmentProfile::updateOrCreate(
            ['session_key' => $sessionId],
            $profileData
        );

        // ──────────────────────────────────────────────────────────
        // 3. Simpan ke Session (akses cepat di seluruh halaman)
        // ──────────────────────────────────────────────────────────
        Session::put('user_name', $request->name);
        Session::put('user_email', $request->email);
        Session::put('user_whatsapp', $request->whatsapp);
        Session::put('identity_session_id', $sessionId);

        return redirect()->intended('/assessment')
            ->with('success', 'Halo ' . $request->name . ', data identitas Anda telah disimpan.');
    }

    /**
     * Logout / Reset Session.
     */
    public function logout()
    {
        Session::flush();
        return redirect('/')->with('info', 'Sesi telah berakhir.');
    }

    /**
     * Mapping identity_type ke status enum di assessment_profiles.
     */
    private function mapIdentityTypeToStatus(string $type): string
    {
        return match($type) {
            'student'            => 'siswa',
            'university_student' => 'mahasiswa',
            'employee'           => 'pekerja',
            default              => 'umum',
        };
    }
}
