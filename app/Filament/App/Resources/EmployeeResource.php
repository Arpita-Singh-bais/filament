<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\EmployeeResource\Pages;
use App\Filament\App\Resources\EmployeeResource\RelationManagers;
use App\Models\City;
use App\Models\Employee;
use App\Models\State;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
 use Illuminate\Support\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Employee Management";
    protected static ?string $recordTitleAttribute = 'first_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('relationship')
                ->schema([
                    Forms\Components\Select::make('country_id')
                        ->relationship(name: 'country', titleAttribute: 'name')
                        ->afterStateUpdated(function (Set $set) {
                            $set('state_id', null);
                            $set('city_id', null);
                        })
                        ->searchable()
                        ->live()
                        ->preload(),

                    Forms\Components\Select::make('state_id')
                        ->options(fn(Get $get): Collection => State::query()
                            ->where('country_id', $get('country_id'))
                            ->pluck('name', 'id'))
                        ->afterStateUpdated(fn(Set $set) => $set('city_id', null))
                        ->searchable()
                        ->preload()
                        ->label('State'),

                    Forms\Components\Select::make('city_id')
                        ->options(fn(Get $get): Collection => City::query()
                            ->where('state_id', $get('state_id'))
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->label('City'),

                    Forms\Components\Select::make('department_id')
                        ->relationship(name: 'department', titleAttribute: 'name',modifyQueryUsing: fn(Builder $query) => $query->whereBelongsTo(Filament::getTenant()))
                        ->searchable()
                        ->preload()
                        ->required(),
                ])->columns(2),

            Section::make('User Name')
                ->description('Settings for publishing this post.')
                ->schema([
                    Forms\Components\TextInput::make('first_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('middle_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('last_name')
                        ->required()
                        ->maxLength(255),
                ])->columns(3),


            Forms\Components\TextInput::make('address')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('zip_code')
                ->required()
                ->maxLength(255),
            Forms\Components\DatePicker::make('date_of_birth')
                ->required()
                ->native(false)
                ->displayFormat('d/m/Y'),

            Forms\Components\DatePicker::make('date_of_hired')
                ->required()
                ->native(false)
                ->displayFormat('d/m/Y'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('first_name')
                ->searchable(),

            Tables\Columns\TextColumn::make('middle_name')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('last_name')
                ->searchable(),
            Tables\Columns\TextColumn::make('address')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('zip_code')
                ->searchable(),
            Tables\Columns\TextColumn::make('date_of_birth')
                ->date()
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),
            Tables\Columns\TextColumn::make('date_of_hired')
                ->date()
                ->sortable(),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('first_name')->label('Employee Name'),
                TextEntry::make('middle_name')->label('Middle Name'),
                TextEntry::make('last_name')->label('Last Name'),
                TextEntry::make('address')->label('Address'),
                TextEntry::make('zip_code')->label('Zip Code'),
                TextEntry::make('date_of_birth')->label('Date of Birth'),
                TextEntry::make('date_of_hired')->label('Date of Hired'),
                TextEntry::make('created_at')->label('Created At'),
                TextEntry::make('updated_at')->label('Updated At'),
                TextEntry::make('department.name')->label('Department Name'),
                TextEntry::make('country.name')->label('Country Name'),
                TextEntry::make('state.name')->label('State Name'),
                TextEntry::make('city.name')->label('City Name'),
                
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
