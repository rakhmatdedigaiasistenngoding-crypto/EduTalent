<?php

namespace App\Http\Controllers;

use App\Models\AssessmentResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(\App\Services\AnalyticsService $analytics)
    {
        // 1. Statistik Dasar
        $totalUsers = User::count();
        $totalAssessments = AssessmentResult::count();
        
        // 2. Feedback & Akurasi (Step-39B)
        $accuracyData = $analytics->calculateAccuracy();
        $feedbackDistribution = $analytics->getFeedbackDistribution();
        
        // 2. Tren profesi teratas (diambil dari kolom result_top_n)
        // Catatan: Karena result_top_n disimpan sebagai JSON, kita lakukan agregasi sederhana
        $recentResults = AssessmentResult::latest()->limit(100)->get();
        $professionStats = [];
        
        foreach ($recentResults as $res) {
            $topProfession = $res->result_top_n[0]['name'] ?? 'Unknown';
            $professionStats[$topProfession] = ($professionStats[$topProfession] ?? 0) + 1;
        }
        
        arsort($professionStats);
        $topProfessions = array_slice($professionStats, 0, 5);

        // 3. Distribusi Karakter (Average RIASEC)
        $riasecTotals = [
            'R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0
        ];
        
        foreach ($recentResults as $res) {
            foreach ($res->input_riasec as $key => $val) {
                if (isset($riasecTotals[$key])) {
                    $riasecTotals[$key] += $val;
                }
            }
        }
        
        $riasecAverages = [];
        if ($totalAssessments > 0) {
            foreach ($riasecTotals as $key => $total) {
                $riasecAverages[$key] = round($total / $totalAssessments, 2);
            }
        }

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalAssessments', 
            'topProfessions',
            'riasecAverages',
            'accuracyData',
            'feedbackDistribution'
        ));
    }
}
