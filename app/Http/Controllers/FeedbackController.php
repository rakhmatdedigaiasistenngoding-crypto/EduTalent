<?php

namespace App\Http\Controllers;

use App\Models\AssessmentFeedback;
use App\Models\AssessmentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    /**
     * Store a new feedback for an assessment result.
     */
    public function store(Request $request)
    {
        $request->validate([
            'assessment_result_id' => 'required|exists:assessment_results,id',
            'rating' => 'required|integer|min:1|max:5',
            'note' => 'nullable|string',
            'source' => 'nullable|string'
        ]);

        $resultId = $request->input('assessment_result_id');

        // Pengecekan Duplicate Prevention (Sesuai arahan Step-39)
        if (AssessmentFeedback::where('assessment_result_id', $resultId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Feedback untuk hasil ini sudah pernah dikirim.'
            ], 422);
        }

        try {
            $feedback = AssessmentFeedback::create([
                'assessment_result_id' => $resultId,
                'user_id' => auth()->id(), // null if guest
                'rating' => $request->input('rating'),
                'note' => $request->input('note'),
                'source' => $request->input('source', 'web'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Feedback tersimpan',
                'data' => $feedback
            ]);
        } catch (\Exception $e) {
            Log::error('Feedback Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan feedback.'
            ], 500);
        }
    }

    /**
     * Tampilkan Metrics (Semi-Admin Route)
     */
    public function metrics()
    {
        // Fitur ini bisa diproteksi dengan auth middleware di routes
        $totalFeedback = AssessmentFeedback::count();
        $averageRating = AssessmentFeedback::avg('rating') ?? 0;
        
        $distribution = AssessmentFeedback::selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->pluck('count', 'rating')->toArray();

        // Mengisi nilai 0 untuk rating yang kosong
        $distData = [];
        for ($i = 5; $i >= 1; $i--) {
            $distData[$i] = $distribution[$i] ?? 0;
        }

        // Profesi dengan rating terendah
        $lowRatedResults = AssessmentFeedback::where('rating', '<=', 2)
            ->with('assessmentResult')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.feedback_metrics', compact(
            'totalFeedback', 'averageRating', 'distData', 'lowRatedResults'
        ));
    }
}
