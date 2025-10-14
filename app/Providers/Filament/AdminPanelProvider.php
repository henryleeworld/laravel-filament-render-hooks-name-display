<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Tables\View\TablesRenderHook;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Widgets\View\WidgetsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use ReflectionClass;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->passwordReset()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->maxContentWidth(Width::Full)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
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
            ]);

        $panelHooks = new ReflectionClass(PanelsRenderHook::class);
        $tableHooks = new ReflectionClass(TablesRenderHook::class);
        $widgetHooks = new ReflectionClass(WidgetsRenderHook::class);

        $panelHooks = $panelHooks->getConstants();
        $tableHooks = $tableHooks->getConstants();
        $widgetHooks = $widgetHooks->getConstants();

        foreach ($panelHooks as $hook) {
            $panel->renderHook($hook, function () use ($hook) {
                return Blade::render('<div style="border: solid red 1px; padding: 2px;">{{ $name }}</div>', [
                    'name' => Str::of($hook)->remove('tables::'),
                ]);
            });
        }
        foreach ($tableHooks as $hook) {
            $panel->renderHook($hook, function () use ($hook) {
                return Blade::render('<div style="border: solid red 1px; padding: 2px;">{{ $name }}</div>', [
                    'name' => Str::of($hook)->remove('tables::'),
                ]);
            });
        }
        foreach ($widgetHooks as $hook) {
            $panel->renderHook($hook, function () use ($hook) {
                return Blade::render('<div style="border: solid red 1px; padding: 2px;">{{ $name }}</div>', [
                    'name' => Str::of($hook)->remove('tables::'),
                ]);
            });
        }

        return $panel;
    }
}
