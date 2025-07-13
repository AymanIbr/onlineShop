<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $request = request();
        if ($request->is('admin/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.prefix', 'admin');
            // Config::set('fortify.home', 'admin/dashboard');
        }

        // login (web,admin)
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                if ($request->user('admin')) {
                    return redirect()->route('admin.index');
                }
                return redirect()->route('site.index');
            }
        });
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

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        if (Config::get('fortify.guard') == 'admin') {
            Fortify::viewPrefix('auth.');
        } else {
            Fortify::viewPrefix('front.auth.');
        }

        // user not active
        Fortify::authenticateUsing(function (Request $request) {

            if (Config::get('fortify.guard') !== 'web') {
                return null;
            }
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if (!$user->active) {
                    throw ValidationException::withMessages([
                        Fortify::username() => ['Your account is not active. Please contact support.'],
                    ]);
                }
                return $user;
            }

            return null;
        });

        // check admin

        if (Config::get('fortify.guard') === 'admin') {
            Fortify::authenticateUsing(function (Request $request) {
                $admin = \App\Models\Admin::where('email', $request->email)->first();
                if ($admin && Hash::check($request->password, $admin->password)) {
                    return $admin;
                }
                return null;
            });
        }
    }
}
