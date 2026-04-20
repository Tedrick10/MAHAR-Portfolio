<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Components\RenderHook;
use Filament\Schemas\Components\View as SchemaView;
use Filament\Schemas\Schema;
use Filament\View\PanelsRenderHook;

class Login extends BaseLogin
{
    public function fillDemoCredentials(): void
    {
        if (! config('demo-login.enabled')) {
            return;
        }

        $this->data = array_merge($this->data ?? [], [
            'email' => config('demo-login.email'),
            'password' => config('demo-login.password'),
        ]);

        $this->form->fill($this->data);
    }

    public function content(Schema $schema): Schema
    {
        $tail = [
            RenderHook::make(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER),
        ];

        if (config('demo-login.enabled')) {
            $tail[] = SchemaView::make('filament.auth.demo-login')
                ->visible(fn (): bool => blank($this->userUndertakingMultiFactorAuthentication));
        }

        return $schema
            ->components([
                RenderHook::make(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE),
                $this->getFormContentComponent(),
                $this->getMultiFactorChallengeFormContentComponent(),
                ...$tail,
            ]);
    }
}
