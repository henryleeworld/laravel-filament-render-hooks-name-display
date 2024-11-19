<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class VerifyUsers extends BaseWidget
{
    /**
     * @deprecated Override the `table()` method to configure the table.
     */
    protected function getTableHeading(): string
    {
        return __('Verified Users');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::where('email_verified_at', null)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
            ]);
    }
}
