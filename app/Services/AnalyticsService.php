<?php

namespace App\Services;

use App\Models\Feedback;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Menghitung akurasi sistem berdasarkan feedback pengguna (Step-39B).
     * Akurasi dihitung dari persentase 'Sangat sesuai' & 'Cukup sesuai' 
     * dibandingkan dengan total feedback.
     */
    public function calculateAccuracy()
    {
        $total = Feedback::count();
        
        if ($total === 0) {
            return [
                'total' => 0,
                'positive' => 0,
                'negative' => 0,
                'accuracy_percentage' => 0,
                'status' => 'No Data'
            ];
        }

        $positive = Feedback::whereIn('rating', ['Sangat sesuai', 'Cukup sesuai'])->count();
        $negative = Feedback::whereIn('rating', ['Kurang sesuai', 'Tidak sesuai'])->count();

        $accuracy = ($positive / $total) * 100;

        return [
            'total' => $total,
            'positive' => $positive,
            'negative' => $negative,
            'accuracy_percentage' => round($accuracy, 2),
            'status' => $this->getAccuracyStatus($accuracy)
        ];
    }

    /**
     * Mendapatkan label status berdasarkan persentase akurasi.
     */
    private function getAccuracyStatus($percentage)
    {
        if ($percentage >= 80) return 'Excellent';
        if ($percentage >= 60) return 'Good';
        if ($percentage >= 40) return 'Fair';
        return 'Needs Improvement';
    }

    /**
     * Mendapatkan distribusi feedback untuk visualisasi.
     */
    public function getFeedbackDistribution()
    {
        return Feedback::select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->get()
            ->pluck('total', 'rating');
    }
}
