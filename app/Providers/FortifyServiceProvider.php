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
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Actions\Fortify\CustomLogoutResponse;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->singleton(LogoutResponse::class, CustomLogoutResponse::class);
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing(function (Request $request) {
            $provider = new CustomUserProvider();
            $user = $provider->retrieveByCredentials([
                'correo_usuario' => $request->input('correo_usuario'),
            ]);
            if (
                $user && $provider->validateCredentials($user, [
                    'password' => $request->input('password'),
                ])
            ) {
                return $user;
            }
        });

        RateLimiter::for(
            'login',
            fn(Request $r) =>
            Limit::perMinute(100)->by(
                Str::lower($r->input(Fortify::username())) . '|' . $r->ip()
            )
        );

        Fortify::loginView(fn() => view('auth.login'));

        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $u = $request->user();
                    $ruta = match ($u->rol_id) {
                        4 => route('laboratorista.dashboard'),
                        3 => route('asistente'),
                        2 => route('odontologo.dashboard'),
                        1 => route('administrador.dashboard'),
                        5 => route('dueno.dashboard'),
                        default => config('fortify.home'),
                    };
                    return $request->wantsJson()
                        ? new JsonResponse(['redirectTo' => $ruta])
                        : redirect()->to($ruta);
                }
            };
        });

        RateLimiter::for(
            'two-factor',
            fn(Request $r) =>
            Limit::perMinute(5)->by($r->session()->get('login.id'))
        );
    }
}
