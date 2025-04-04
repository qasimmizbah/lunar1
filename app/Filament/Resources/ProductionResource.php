<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductionResource\Pages;
use App\Filament\Resources\ProductionResource\RelationManagers;
use App\Models\Production;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected static ?string $navigationGroup = "Shop";

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $navigationLabel = 'Publication';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make(heading:'Basic Info')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                            ->required(),
                            Forms\Components\Toggle::make('is_visible'),
                            Forms\Components\MarkdownEditor::make('description'),
                            
                            
                        ]),
                    ]),


                    Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make(heading:'SEO')
                        ->schema([
                            Forms\Components\TextInput::make('meta_tag_title'),
                            Forms\Components\MarkdownEditor::make('meta_tag_description'),
                            Forms\Components\MarkdownEditor::make('meta_tag_keywords'),
                            
                            
                            
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
       
        ->columns([
            Tables\Columns\TextColumn::make(name: 'name'),
            Tables\Columns\TextColumn::make(name: 'meta_tag_description')
            ->grow(false)
            ->limit('50'),
        
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
            'index' => Pages\ListProductions::route('/'),
            'create' => Pages\CreateProduction::route('/create'),
            'edit' => Pages\EditProduction::route('/{record}/edit'),
        ];
    }
}
