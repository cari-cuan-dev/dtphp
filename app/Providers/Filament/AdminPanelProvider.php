<?php

namespace App\Providers\Filament;

use Agencetwogether\HooksHelper\HooksHelperPlugin;
use App\Filament\Pages\DashboardMain;
use App\Filament\Pages\Login as PagesLogin;
use Awcodes\LightSwitch\Enums\Alignment;
use Awcodes\LightSwitch\LightSwitchPlugin;
use Filament\Auth\Pages\Login;
use Filament\Forms\Components\TextInput;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Hexters\HexaLite\HexaLite;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('emonev')
            ->path('emonev')
            ->login(PagesLogin::class)
            ->favicon('/images/logo/Brand.png')
            ->profile()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                DashboardMain::class,
                // Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                HexaLite::make(),
                // HooksHelperPlugin::make(),
                // LightSwitchPlugin::make()
                //     ->position(Alignment::TopCenter),
                FilamentBackgroundsPlugin::make()
                    ->imageProvider(
                        MyImages::make()
                            // ->directory('images/swisnl/filament-backgrounds/triangles')
                            ->directory('images/background-login')
                    ),

            ])
            ->viteTheme([
                'public/css/filament/filament/app.css',
                'resources/css/light-switch.css'
            ])
            ->renderHook(
                'panels::auth.login.form.before',
                fn() => view('filament.hooks.login-heading')
            )
            ->renderHook(
                'panels::simple-page.end',
                fn() => view('filament.hooks.login-footer')
            )
            ->spa();
    }
}
