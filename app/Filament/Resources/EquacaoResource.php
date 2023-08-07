<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquacaoResource\Pages;
use App\Filament\Resources\EquacaoResource\RelationManagers;
use App\Models\Equacao;
use App\Models\Ponto;
use Filament\Forms;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquacaoResource extends Resource
{
    protected static ?string $model = Equacao::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Equação';

    protected static ?string $pluralModelLabel = 'Equações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('formula')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Repeater::make('equacionaveis')
                    ->label('Variáveis')
                    ->columnSpanFull()
                    ->collapsible()
                    ->minItems(1)
                    ->relationship('equacionaveis')
                    ->schema([
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('grandeza')
                            ->options(['Energia' => 'Energia'])
                            ->hidden(fn ($get) => $get('nome') == '123' || empty($get('equacionavel_type')) || $get('equacionavel_type') === Equacao::class)
                            ->live()
                            ->requiredIf('equacionavel_type', Ponto::class),
                        Forms\Components\MorphToSelect::make('variavel')
                            ->label('Variável')
                            ->required()
                            ->types([
                                MorphToSelect\Type::make(Ponto::class)
                                    ->titleAttribute('nome'),
                                MorphToSelect\Type::make(Equacao::class)
                                    ->titleAttribute('nome'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('formula')
                    ->label('Fórmula')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquacaos::route('/'),
            'create' => Pages\CreateEquacao::route('/create'),
            'edit' => Pages\EditEquacao::route('/{record}/edit'),
        ];
    }
}
