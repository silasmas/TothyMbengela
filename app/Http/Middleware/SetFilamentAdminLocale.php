<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetFilamentAdminLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin') || $request->is('admin/*')) {
            app()->setLocale('fr');
        } elseif ($request->is('livewire/*')) {
            $referer = $request->headers->get('referer');
            if ($referer !== null) {
                $path = parse_url($referer, PHP_URL_PATH);
                if (is_string($path) && str_contains($path, '/admin')) {
                    app()->setLocale('fr');
                }
            }
        }

        return $next($request);
    }
}
