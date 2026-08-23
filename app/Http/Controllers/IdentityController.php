<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IdentityLinkingService;

class IdentityController extends Controller
{
    public function __construct(
        protected IdentityLinkingService $linkingService
    ) {}

    public function link(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $success = $this->linkingService->linkByToken(
            $request->token,
            auth()->user()
        );

        if (!$success) {
            return back()->with('error', 'Token tidak valid atau tidak diizinkan.');
        }

        return back()->with('success', 'Akun berhasil dihubungkan.');
    }
    public function linkApi(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $success = $this->linkingService->linkByToken(
            $request->token,
            auth()->user()
        );

        if (!$success) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid atau tidak diizinkan.'
            ], 400);
        }

        session()->flash('success', 'Akun berhasil dihubungkan via token.');

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dihubungkan.'
        ]);
    }

    public function linkSession(Request $request, \App\Services\IdentityResolverService $resolver)
    {
        // Temukan potential identity dari session berjalan
        $potentialIdentity = $resolver->detectPotentialIdentity();

        if (!$potentialIdentity) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data asesmen dari sesi saat ini.'
            ], 404);
        }

        try {
            $success = $this->linkingService->linkIdentity($potentialIdentity, auth()->user());
            
            if ($success) {
                // [STEP-38E] Logging Aktivitas Produksi
                \Illuminate\Support\Facades\Log::info('Identity Linked', [
                    'source_identity' => $potentialIdentity->id,
                    'target_user' => auth()->id(),
                    'timestamp' => now()->toDateTimeString()
                ]);

                session()->flash('success', 'Data sesi berhasil dihubungkan otomatis.');
                return response()->json([
                    'success' => true,
                    'message' => 'Data sesi berhasil dihubungkan.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menghubungkan data.'
        ], 400);
    }
}
