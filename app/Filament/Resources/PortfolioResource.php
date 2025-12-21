<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Models\Portfolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')->required()->readOnly(),

                Select::make('category')
                    ->options([
                        'Web Development' => 'Web Development',
                        'Mobile App' => 'Mobile App',
                        'UI/UX Design' => 'UI/UX Design',
                        'IoT' => 'IoT',
                    ])
                    ->required(),

                TextInput::make('link')->url()->label('Link Project'),

                FileUpload::make('image')
                    ->image()
                    // TAMBAHAN PENTING: Paksa simpan ke S3 (MinIO) & set public
                    ->disk('s3')
                    ->visibility('public')
                    ->directory('portfolios') // Ini akan membuat folder: sainzlab-storage/portfolios/
                    ->fetchFileInformation(false)
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('is_active')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    // TAMBAHAN PENTING: Biar preview gambarnya ambil dari S3 (CDN)
                    ->disk('s3')
                    ->visibility('public'),

                TextColumn::make('title')->searchable(),

                TextColumn::make('category')
                    ->badge()
                    ->color('primary'),

                ToggleColumn::make('is_active'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
}
