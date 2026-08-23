<?php

namespace Tests\Feature;

use App\Services\EngineService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EngineServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Mendapatkan instance EngineService.
     */
    protected function getEngine(): EngineService
    {
        return app(EngineService::class);
    }

    /**
     * Mendapatkan data user simulasi.
     */
    protected function getUser(): array
    {
        return [
            'trait' => [0.8, 0.7, 0.75],
            'riasec' => [0.8, 0.2, 0.3, 0.4, 0.5, 0.6],
            'environment' => [0.9, 0.8, 0.85]
        ];
    }

    /**
     * Test engine mengembalikan hasil Top 1 dengan benar.
     */
    public function test_engine_returns_top_1_result(): void
    {
        // 0. Setup data
        $this->seed(\Database\Seeders\ProfessionSeeder::class);

        // 1. Jalankan engine dengan limit 1
        $engine = $this->getEngine();
        $output = $engine->run($this->getUser(), 1);

        // 2. Validasi jumlah hasil
        $this->assertCount(1, $output['results']);

        // 3. Validasi hasil adalah score tertinggi (Software Engineer)
        $this->assertEquals('Software Engineer', $output['results'][0]['name']);
    }

    /**
     * Test engine mengembalikan hasil Top 2 dalam urutan yang benar.
     */
    public function test_engine_returns_top_2_results_in_correct_order(): void
    {
        // 0. Setup data
        $this->seed(\Database\Seeders\ProfessionSeeder::class);

        // 1. Jalankan engine dengan limit 2
        $engine = $this->getEngine();
        $output = $engine->run($this->getUser(), 2);

        // 2. Validasi jumlah hasil
        $this->assertCount(2, $output['results']);

        // 3. Validasi urutan (index 0 > index 1)
        $this->assertEquals('Software Engineer', $output['results'][0]['name']);
        $this->assertEquals('Data Analyst', $output['results'][1]['name']);
    }

    /**
     * Test engine mengembalikan semua hasil (full ranking) jika limit adalah null.
     */
    public function test_engine_returns_all_results_when_limit_is_null(): void
    {
        // 0. Setup data
        $this->seed(\Database\Seeders\ProfessionSeeder::class);

        // 1. Jalankan engine dengan limit null
        $engine = $this->getEngine();
        $output = $engine->run($this->getUser(), null);

        // 2. Validasi jumlah hasil (seeder memasukkan 3 data, jadi harus > 2)
        $this->assertGreaterThan(2, count($output['results']));

        // 3. Validasi urutan tetap konsisten (Top 1 tetap Software Engineer)
        $this->assertEquals('Software Engineer', $output['results'][0]['name']);
    }

    /**
     * Test engine mengembalikan hasil kosong jika limit adalah 0.
     */
    public function test_engine_returns_empty_when_limit_is_zero(): void
    {
        // 0. Setup data
        $this->seed(\Database\Seeders\ProfessionSeeder::class);

        // 1. Jalankan engine dengan limit 0
        $engine = $this->getEngine();
        $output = $engine->run($this->getUser(), 0);

        // 2. Validasi jumlah hasil harus 0
        $this->assertCount(0, $output['results']);
    }

    /**
     * Test normalisasi menghasilkan ranking yang konsisten meskipun skala berbeda.
     */
    public function test_engine_normalization_produces_consistent_ranking(): void
    {
        // 0. Setup data
        $this->seed(\Database\Seeders\ProfessionSeeder::class);

        // 1. Input A (Skala 0-1)
        $userA = [
            'trait' => [0.8, 0.7, 0.75],
            'riasec' => [0.8, 0.2, 0.3, 0.4, 0.5, 0.6],
            'environment' => [0.9, 0.8, 0.85]
        ];

        // 2. Input B (Skala 0-10)
        $userB = [
            'trait' => [8, 7, 7.5],
            'riasec' => [8, 2, 3, 4, 5, 6],
            'environment' => [9, 8, 8.5]
        ];

        $engine = $this->getEngine();
        $outputA = $engine->run($userA);
        $outputB = $engine->run($userB);

        // 3. Validasi Ranking Nama harus sama persis di setiap posisi
        foreach ($outputA['results'] as $key => $result) {
            $this->assertEquals($result['name'], $outputB['results'][$key]['name']);
        }

        // 4. Validasi Top 1 tetap Software Engineer
        $this->assertEquals('Software Engineer', $outputA['results'][0]['name']);
        $this->assertEquals('Software Engineer', $outputB['results'][0]['name']);

        // 5. Validasi Score (Toleransi delta karena pembulatan float)
        $this->assertEqualsWithDelta(
            $outputA['results'][0]['score'], 
            $outputB['results'][0]['score'], 
            0.001
        );
    }

    /**
     * Test bahwa perubahan bobot secara dinamis mempengaruhi ranking hasil.
     */
    public function test_engine_weighting_affects_ranking(): void
    {
        // 0. Setup data
        $this->seed(\Database\Seeders\ProfessionSeeder::class);

        // 1. Data User:
        // Cocok dengan Software Engineer (SE) di Trait (0.9, 0.8, 0.85)
        // Cocok dengan Data Analyst (DA) di Riasec (0.7, 0.3, 0.4, 0.6, 0.5, 0.8)
        $user = [
            'trait' => [0.9, 0.8, 0.85],
            'riasec' => [0.7, 0.3, 0.4, 0.6, 0.5, 0.8],
            'environment' => [0.7, 0.6, 0.65]
        ];

        $engine = $this->getEngine();

        // 2. Skenario A: Default Weight (Fokus Trait: 0.5)
        // Ekspektasi: Software Engineer peringkat 1 karena trait match 100%
        $outputDefault = $engine->run($user);
        $topDefault = $outputDefault['results'][0]['name'];

        // 3. Skenario B: Custom Weight (Fokus Riasec: 0.6)
        // Ekspektasi: Data Analyst naik peringkatnya karena riasec match 100%
        $userCustom = $user;
        $userCustom['weights'] = [
            'trait' => 0.2,
            'riasec' => 0.6,
            'environment' => 0.2
        ];
        $outputCustom = $engine->run($userCustom);
        $topCustom = $outputCustom['results'][0]['name'];

        // 4. Validasi: Ranking teratas harus berbeda
        $this->assertNotEquals($topDefault, $topCustom, "Ranking teratas harus berubah saat bobot diubah.");
        
        // 5. Validasi spesifik (Berdasarkan data seeder)
        $this->assertEquals('Software Engineer', $topDefault);
        $this->assertEquals('Data Analyst', $topCustom);

        // 6. Validasi output range (0-1)
        foreach ($outputCustom['results'] as $result) {
            $this->assertGreaterThanOrEqual(0, $result['score']);
            $this->assertLessThanOrEqual(1, $result['score']);
        }
    }

    /**
     * Test penanganan edge case pada pembobotan (all zero, extreme, missing keys).
     */
    public function test_engine_weighting_edge_cases(): void
    {
        // 0. Setup data
        $this->seed(\Database\Seeders\ProfessionSeeder::class);
        $user = $this->getUser();
        $engine = $this->getEngine();

        // 1. Kasus All-Zero Weights
        // Ekspektasi: Fallback ke default, hasil harus sama dengan run tanpa weights
        $userAllZero = $user;
        $userAllZero['weights'] = ['trait' => 0, 'riasec' => 0, 'environment' => 0];
        
        $outputDefault = $engine->run($user);
        $outputAllZero = $engine->run($userAllZero);
        
        $this->assertEquals(
            $outputDefault['results'][0]['score'], 
            $outputAllZero['results'][0]['score'], 
            "Harus fallback ke default jika semua bobot adalah 0."
        );

        // 2. Kasus Bobot Ekstrem (Normalisasi)
        // Ekspektasi: Sistem tetap stabil dan mengutamakan kriteria dengan bobot terbesar
        $userExtreme = $user;
        $userExtreme['weights'] = ['trait' => 1000, 'riasec' => 1, 'environment' => 1];
        
        $outputExtreme = $engine->run($userExtreme);
        
        $this->assertGreaterThan(0, $outputExtreme['results'][0]['score']);
        $this->assertLessThanOrEqual(1, $outputExtreme['results'][0]['score']);

        // 3. Kasus Missing Keys
        // Ekspektasi: Kunci yang hilang dianggap bobot 0, tidak menyebabkan error
        $userMissingKeys = $user;
        $userMissingKeys['weights'] = ['trait' => 1]; // Tanpa riasec dan environment
        
        $outputMissing = $engine->run($userMissingKeys);
        
        $this->assertArrayHasKey('results', $outputMissing);
        $this->assertNotEmpty($outputMissing['results']);
    }

    /**
     * Test domain filtering (Tanpa domain, Teknologi, Kreatif).
     */
    public function test_engine_domain_filtering(): void
    {
        // 0. Setup data
        $this->seed(\Database\Seeders\ProfessionSeeder::class);
        $user = $this->getUser();
        $engine = $this->getEngine();

        // 1. Tanpa Filter Domain
        // Ekspektasi: Muncul semua profesi (Software Engineer, Graphic Designer, Data Analyst)
        $outputAll = $engine->run($user, null);
        $this->assertCount(3, $outputAll['results'], "Hasil harus mencakup semua profesi jika tanpa filter domain.");

        // 2. Filter Domain = Teknologi
        // Ekspektasi: Hanya Software Engineer
        $userTekno = $user;
        $userTekno['domain'] = 'Teknologi';
        $outputTekno = $engine->run($userTekno);
        
        $this->assertCount(1, $outputTekno['results'], "Harus hanya ada 1 hasil untuk domain Teknologi.");
        $this->assertEquals('Software Engineer', $outputTekno['results'][0]['name']);

        // 3. Filter Domain = Kreatif
        // Ekspektasi: Hanya Graphic Designer
        $userKreatif = $user;
        $userKreatif['domain'] = 'Kreatif';
        $outputKreatif = $engine->run($userKreatif);
        
        $this->assertCount(1, $outputKreatif['results'], "Harus hanya ada 1 hasil untuk domain Kreatif.");
        $this->assertEquals('Graphic Designer', $outputKreatif['results'][0]['name']);
    }

    /**
     * Test edge case domain filtering (Null, Empty, Not Found).
     */
    public function test_engine_domain_filtering_edge_cases(): void
    {
        // 0. Setup data
        $this->seed(\Database\Seeders\ProfessionSeeder::class);
        $user = $this->getUser();
        $engine = $this->getEngine();

        // 1. Domain = Null
        // Ekspektasi: Fallback ke semua data
        $userNull = $user;
        $userNull['domain'] = null;
        $outputNull = $engine->run($userNull, null);
        $this->assertCount(3, $outputNull['results'], "Domain null harus fallback ke semua data.");

        // 2. Domain = Kosong ("")
        // Ekspektasi: Fallback ke semua data
        $userEmpty = $user;
        $userEmpty['domain'] = "";
        $outputEmpty = $engine->run($userEmpty, null);
        $this->assertCount(3, $outputEmpty['results'], "Domain kosong harus fallback ke semua data.");

        // 3. Domain Tidak Ditemukan (e.g. 'Ghaib')
        // Ekspektasi: Fallback ke semua data
        $userGhaib = $user;
        $userGhaib['domain'] = 'Ghaib';
        $outputGhaib = $engine->run($userGhaib, null);
        $this->assertCount(3, $outputGhaib['results'], "Domain tidak terdaftar harus fallback ke semua data.");
    }
}
