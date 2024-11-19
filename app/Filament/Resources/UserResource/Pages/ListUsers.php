<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            Tab::make('Verified')->label(__('Verified'))->query(fn ($query) => $query->whereNotNull('email_verified_at')),
            Tab::make('Unverified')->label(__('Unverified'))->query(fn ($query) => $query->whereNull('email_verified_at')),
        ];
    }
}
