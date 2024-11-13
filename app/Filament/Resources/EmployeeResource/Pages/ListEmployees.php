<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

        ];

    }

    // public function getTabs(): array
    // {
    //     return [
    //         'All' => Tab::make('All'),
    //         'This week' => Tab::make('This week')
    //         // ->modifyQueryUsing(fn (Builder $query) => $query->where('date_of_hired', '>=', now()->subWeek(2)))
              
    //             ->badge(Employee::query()->where('date_of_hired', '>=', now()->subDays())->count()),

    //         'this month' => Tab::make('this month')
    //             // ->modifyQueryUsing(fn(Builder $query) => $query->where('created_at', '>=', now()->subMonth()))
    //             ->badge(Employee::query()->where('created_at', '>=', now()->subMonth())->count()),
    //         'this year' => Tab::make('this year')
    //             // ->modifyQueryUsing(fn(Builder $query) => $query->where('created_at', '>=', now()->subYear(1)))
    //             ->badge(Employee::query()->where('created_at', '>=', now()->subYear(1))->count()),

    //     ];
    // }
}
