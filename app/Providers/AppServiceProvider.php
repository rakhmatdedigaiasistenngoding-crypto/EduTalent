<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            Storage::extend('google', function($app, $config) {
                $client = new \Google\Client();
                
                // Mengatasi error cURL 60 di Windows (SSL issue)
                $httpClient = new \GuzzleHttp\Client(['verify' => false]);
                $client->setHttpClient($httpClient);

                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);
                
                $service = new \Google\Service\Drive($client);
                $adapter = new GoogleDriveAdapter($service, $config['folderId'] ?? null);
                $filesystem = new Filesystem($adapter);

                return new \Illuminate\Filesystem\FilesystemAdapter($filesystem, $adapter);
            });
        } catch (\Exception $e) {
            // Biarkan gagal diam-diam jika tidak sedang digunakan
        }

        \Illuminate\Support\Facades\Event::listen(function (\Illuminate\Auth\Events\Login $event) {
            if (session()->has('assessment_token')) {
                $assessmentToken = session('assessment_token');
                
                $success = app(\App\Services\IdentityLinkingService::class)->autoLink(
                    $event->user instanceof \App\Models\User ? $event->user : \App\Models\User::find($event->user->getAuthIdentifier()),
                    $assessmentToken
                );

                session()->forget('assessment_token');

                if ($success) {
                    session()->flash('success', '✔ Hasil asesmen Anda berhasil disimpan');
                }
            }
        });
    }
}
