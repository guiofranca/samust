<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RelatorioSamustResource\Pages;
use App\Filament\Resources\RelatorioSamustResource\RelationManagers;
use App\Filament\Resources\RelatorioSamustResource\RelationManagers\MustsRelationManager;
use App\Filament\Resources\RelatorioSamustResource\RelationManagers\PontoRelationManager;
use App\Models\RelatorioSamust;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RelatorioSamustResource extends Resource
{
    protected static ?string $model = RelatorioSamust::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Section::make('Cadastro de Musts')
                    ->collapsed(true)
                    ->schema([
                        Forms\Components\Repeater::make('musts')
                            ->columnSpanFull()
                            ->relationship('musts')
                            ->minItems(1)
                            ->schema([
                                Forms\Components\Select::make('ponto_id')
                                    ->relationship('ponto', 'nome')
                                    ->native(false),
                                Forms\Components\TextInput::make('limite')->numeric(),
                                Forms\Components\Select::make('equacao_id')
                                    ->relationship('equacao', 'nome')
                                    ->native(false),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MustsRelationManager::class,
            PontoRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRelatorioSamusts::route('/'),
            'create' => Pages\CreateRelatorioSamust::route('/create'),
            'edit' => Pages\EditRelatorioSamust::route('/{record}/edit'),
        ];
    }
}
