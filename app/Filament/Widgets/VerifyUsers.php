<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class VerifyUsers extends TableWidget
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
            ->query(fn (): Builder => User::where('email_verified_at', null))
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
            ]);
    }
}
