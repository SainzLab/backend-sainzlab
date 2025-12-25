<?php

namespace App\Filament\Widgets;

use App\Models\Portfolio;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

    class LatestPortfolios extends BaseWidget
    {
        protected static ?int $sort = 3;

        protected int | string | array $columnSpan = 'full';

        protected static ?string $heading = 'Proyek Terbaru';

        public function table(Table $table): Table
        {
            return $table
                ->query(
                    Portfolio::query()->latest()->limit(5)
                )
                ->columns([
                    Tables\Columns\ImageColumn::make('image')
                        ->label('Image')
			->disk('s3')
			->visibility('public'),
                    Tables\Columns\TextColumn::make('title')
                        ->label('Judul Proyek')
                        ->searchable()
                        ->sortable()
                        ->weight('bold'),

                    Tables\Columns\TextColumn::make('category')
                        ->badge()
                        ->color('info'),

                    Tables\Columns\TextColumn::make('created_at')
                        ->label('Dibuat Pada')
                        ->dateTime('d M Y')
                        ->sortable()
                        ->color('gray'),
                ])
                ->paginated(false);
        }
    }
