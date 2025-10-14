<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'verified' => Tab::make()
                ->label(__('Verified'))
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('email_verified_at')),
            'unverified' => Tab::make()
                ->label(__('Unverified'))
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('email_verified_at')),
        ];
    }
}
