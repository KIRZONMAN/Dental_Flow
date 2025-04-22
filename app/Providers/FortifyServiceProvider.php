<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
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
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Usar tu proveedor de usuarios personalizado
        Fortify::authenticateUsing(function (Request $request) {
            $userProvider = new CustomUserProvider();

            $user = $userProvider->retrieveByCredentials([
                'correo_usuario' => $request->input('correo_usuario'),
                'contrasena_usuario' => $request->input('contrasena_usuario')
            ]);

            if ($user && $userProvider->validateCredentials($user, $request->only('password'))) {
                return $user;
            }
        });

        RateLimiter::for('login', function (Request $request) {
           $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(100)->by($throttleKey);
        });

        Fortify::loginView(function () {
            return view('auth.login'); // Asegúrate de que esta vista exista
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
