<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\DecisionService;

/**
 * Unit Test untuk DecisionService
 * [FIX T-35-05] - Implementasi unit test untuk menutup celah verifikasi otomatis
 */
class DecisionServiceTest extends TestCase
{
    private DecisionService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DecisionService();
    }

    // ============================================================
    // STEP-35A: calculateDecisionScore
    // ============================================================

    /** @test */
    public function test_decision_score_default_exploration_mode()
    {
        // Mode eksplorasi: bobot engine 70%, stabilitas 30%
        $score = $this->service->calculateDecisionScore(
            ['score' => 0.8],
            stability: 0.6,
            preference: 'exploration'
        );

        // Expected: (0.8 * 0.7) + (0.6 * 0.3) = 0.56 + 0.18 = 0.74
        $this->assertEqualsWithDelta(0.74, $score, 0.001);
    }

    /** @test */
    public function test_decision_score_stability_mode()
    {
        // Mode stabilitas: bobot engine 30%, stabilitas 70%
        $score = $this->service->calculateDecisionScore(
            ['score' => 0.8],
            stability: 0.6,
            preference: 'stability'
        );

        // Expected: (0.8 * 0.3) + (0.6 * 0.7) = 0.24 + 0.42 = 0.66
        $this->assertEqualsWithDelta(0.66, $score, 0.001);
    }

    /** @test */
    public function test_decision_score_with_invalid_preference_falls_back_to_exploration()
    {
        // Input tidak valid → fallback ke exploration (bobot engine 70%)
        $score = $this->service->calculateDecisionScore(
            ['score' => 1.0],
            stability: 0.0,
            preference: 'invalid_value'
        );

        // Expected: (1.0 * 0.7) + (0.0 * 0.3) = 0.70
        $this->assertEqualsWithDelta(0.70, $score, 0.001);
    }

    /** @test */
    public function test_decision_score_returns_value_between_zero_and_one()
    {
        $score = $this->service->calculateDecisionScore(
            ['score' => 0.5],
            stability: 0.5,
            preference: 'exploration'
        );

        $this->assertGreaterThanOrEqual(0, $score);
        $this->assertLessThanOrEqual(1, $score);
    }

    /** @test */
    public function test_decision_score_with_missing_score_key()
    {
        // Harus aman meski key 'score' tidak ada
        $score = $this->service->calculateDecisionScore(
            [],
            stability: 0.5,
            preference: 'exploration'
        );

        // Expected: (0 * 0.7) + (0.5 * 0.3) = 0.15
        $this->assertEqualsWithDelta(0.15, $score, 0.001);
    }

    // ============================================================
    // STEP-35E: confidenceLevel
    // ============================================================

    /** @test */
    public function test_confidence_level_tinggi_when_score_above_0_8()
    {
        $this->assertEquals('Tinggi', $this->service->confidenceLevel(0.85));
        $this->assertEquals('Tinggi', $this->service->confidenceLevel(1.0));
        $this->assertEquals('Tinggi', $this->service->confidenceLevel(0.80));
    }

    /** @test */
    public function test_confidence_level_cukup_when_score_between_0_6_and_0_8()
    {
        $this->assertEquals('Cukup', $this->service->confidenceLevel(0.75));
        $this->assertEquals('Cukup', $this->service->confidenceLevel(0.60));
    }

    /** @test */
    public function test_confidence_level_rendah_when_score_below_0_6()
    {
        $this->assertEquals('Rendah', $this->service->confidenceLevel(0.59));
        $this->assertEquals('Rendah', $this->service->confidenceLevel(0.0));
    }

    // ============================================================
    // STEP-35D: explainDecision
    // ============================================================

    /** @test */
    public function test_explain_decision_is_not_empty()
    {
        $explanation = $this->service->explainDecision(
            ['score' => 0.8],
            stability: 0.7,
            preference: 'exploration'
        );

        $this->assertNotEmpty($explanation);
        $this->assertIsString($explanation);
    }

    /** @test */
    public function test_explain_decision_stability_scenario()
    {
        // Skenario 1: stabilitas tinggi + mode stabilitas
        $explanation = $this->service->explainDecision(
            ['score' => 0.8],
            stability: 0.80,
            preference: 'stability'
        );

        // Harus mengandung kata kunci "konsisten" atau "stabil"
        $this->assertStringContainsStringIgnoringCase('konsisten', $explanation);
    }

    /** @test */
    public function test_explain_decision_low_stability_scenario()
    {
        // Skenario 3: stabilitas rendah (explorer)
        $explanation = $this->service->explainDecision(
            ['score' => 0.7],
            stability: 0.4,
            preference: 'exploration'
        );

        // Harus mengandung kata kunci yang relevan dengan kondisi berkembang
        $this->assertStringContainsStringIgnoringCase('berkembang', $explanation);
    }
}
