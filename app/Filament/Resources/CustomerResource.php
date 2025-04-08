<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = "Shop";

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                Forms\Components\TextInput::make( name: 'name')
                ->maxValue(value: 50)
                ->required(),
                Forms\Components\TextInput::make( name: 'email')
                ->label( label: 'Email Address')
                ->required()
                ->email()
                ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make( name: 'phone')
                ->label( label: 'Phone Number')
                ->required()
                ->maxValue(value: 50),
                Forms\Components\DatePicker::make( name: 'date_of_birth')
                ->label( label: 'Date of Birth'),
                Forms\Components\TextInput::make( name: 'city')
                ->label( label: 'City'),
                Forms\Components\TextInput::make( name: 'zip_code')
                ->label( label: 'City'),
                Forms\Components\TextInput::make( name: 'address')
                ->label( label: 'Address'),
                
                ]),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'name')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make(name: 'email')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make(name: 'phone')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make(name: 'city')
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),

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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
