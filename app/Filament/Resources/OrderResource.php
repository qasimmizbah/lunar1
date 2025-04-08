<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Symfony\Contracts\Service\Attribute\Required;

use function Livewire\Volt\dehydrate;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = "Shop";

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', '=', 'processing')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                    Wizard::make([
                        Wizard\Step::make('Step 1')
                            ->schema([
                                Forms\Components\TextInput::make( name: 'number')
                                ->default(state:'OR-'. random_int(10000, 99999))
                                ->required(),
                                Forms\Components\Select::make(name: "customer.name")
                                ->relationship(name : 'customer', titleAttribute:'name')
                                ->searchable()
                                ->required(),

                                Select::make(name:'type')
                                ->options([
                                    "pending"=>"Pending",
                                     "processing"=>"Processing",
                                      "completed"=>"Completed",
                                       "declined"=>"Declined",
                                ])->columnSpanFull()->required(),

                                MarkdownEditor::make(name: 'notes')
                                ->columnSpanFull(),
                            ])->columns(2),


                        Wizard\Step::make('Order Item')
                            ->schema([
                              
                                Repeater::make(name: 'items')

                                ->relationship()

                                ->schema([
                                    Forms\Components\Select::make(name: "product_id")
                                    ->label(label: 'Products')
                                    ->searchable()
                                    -> options(Product::query()->pluck(column:'name',key:'id'))
                                    ->required(),
                                    Forms\Components\TextInput::make(name: "quntity")
                                    ->label(label: 'Stock Quntity')
                                    ->numeric()
                                    ->default(state:1)
                                    ->required(),
                                
                                Forms\Components\TextInput::make(name: "unit_price")
                                    ->label(label: 'Unit Price')
                                    ->numeric()
                                    ->disabled()
                                    
                                    ->Required(),
                                ])->columns(3),

                                

                            ]),
                    ])->columnSpanFull(),
                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'Number')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make(name: 'customer.name')
                ->sortable()
                ->toggleable()
                ->searchable(),
                Tables\Columns\TextColumn::make(name: 'status')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make(name: 'total_price')
                ->sortable()
                ->searchable()
                ->summarize(
                    [
                        Tables\Columns\Summarizers\Sum::make()->money(),
                    ]
                ),
                Tables\Columns\TextColumn::make(name: 'created_date')
                ->label(label : "Order Date")
                ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
