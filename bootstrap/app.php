<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (\Throwable $e) {
            $data = [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ];

            // Cek apakah auth terikat di container sebelum dipanggil
            if (app()->bound('auth') && auth()->check()) {
                $data['user_id'] = auth()->id();
            }

            // Cek apakah bukan di console (CLI) sebelum panggil request
            if (!app()->runningInConsole() && app()->bound('request')) {
                $data['url'] = request()->fullUrl();
                $data['ip'] = request()->ip();
            }

            \Illuminate\Support\Facades\Log::error('System Exception [BOOT_CRASH_PROTECTED]', $data);
        });
    })->create();
