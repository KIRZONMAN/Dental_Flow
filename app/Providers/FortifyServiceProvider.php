<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Providers\CustomUserProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Autenticación personalizada
        Fortify::authenticateUsing(function (Request $request) {
            $provider = new CustomUserProvider();
            $user = $provider->retrieveByCredentials([
                'correo_usuario' => $request->input('correo_usuario'),
            ]);

            if ($user && $provider->validateCredentials($user, [
                'password' => $request->input('password'),
            ])) {
                return $user;
            }
        });



        RateLimiter::for('login', function (Request $request) {
            $key = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(100)->by($key);
        });

        Fortify::loginView(fn() => view('auth.login'));

        // respuesta tras login, con rutas corregidas
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $user = $request->user();
                    \Log::info("LoginResponse invocado para {$user->correo_usuario} con rol {$user->rol_id}");
                    /* desde aquí corregí: las rutas deben coincidir con los names que definiste en web.php */
                    $ruta = match ($user->rol_id) {
                        4 => route('laboratorista.dashboard'),
                        3 => route('asistente'),            // << aquí estaba 'asistente.dashboard'
                        2 => route('odontologo.dashboard'), // asegúrate de darle name('odontologo.dashboard')
                        1 => route('administrador.dashboard'), // idem para admin
                        5 => route('dueno.dashboard'),
                        default => config('fortify.home'),
                    };
                    /* hasta aquí corregí */

                    if ($request->wantsJson()) {
                        return new JsonResponse(['redirectTo' => $ruta]);
                    }

                    return redirect()->to($ruta);
                }
            };
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

    }
}
