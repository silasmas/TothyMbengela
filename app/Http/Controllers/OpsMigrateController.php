<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Throwable;

/**
 * Exécute les migrations via une URL protégée par jeton (déploiement sans SSH).
 */
class OpsMigrateController extends Controller
{
    /**
     * Lance `php artisan migrate --force` si le jeton MIGRATE_TOKEN est valide.
     *
     * @param  Request  $request  Requête HTTP (query `token`)
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $expected = (string) config('app.migrate_token', '');

        if ($expected === '') {
            abort(404);
        }

        $provided = (string) $request->query('token', '');

        if (! hash_equals($expected, $provided)) {
            abort(403, 'Jeton invalide.');
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = trim(Artisan::output());

            if ($output === '') {
                $output = 'Migrations exécutées (aucune sortie).';
            }

            return response($output, 200)
                ->header('Content-Type', 'text/plain; charset=UTF-8');
        } catch (Throwable $e) {
            report($e);

            return response(
                "Erreur lors des migrations :\n".$e->getMessage(),
                500
            )->header('Content-Type', 'text/plain; charset=UTF-8');
        }
    }
}
