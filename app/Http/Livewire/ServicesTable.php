<?php

namespace App\Http\Livewire;

use App\Models\Services;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ServicesTable extends LivewireTableComponent
{
    protected $model = Services::class;

    public $showButtonOnHeader = true;

    public $buttonComponent = 'services.table_components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setThAttributes(function (Column $column) {
            return [
                'class' => 'text-center',
            ];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '2') {
                return [
                    'class' => 'text-center',
                    'width' => '15%',

                ];
            }
            if ($columnIndex == '1') {
                return [
                    'class' => 'text-center',
                ];
            }

            return [];
        });

        $this->setTableAttributes(
            [
                'default' => false,
                'class' => 'table table-striped',
            ]);

        $this->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.services.name'), 'name')
                ->sortable()
                ->searchable()
                ->view('services.table_components.name'),
            Column::make(__('messages.services.description'), 'description')
                ->sortable()
                ->searchable()
                ->view('services.table_components.description'),

            // Column::make(__('messages.common.download'), 'id')
            //     ->view('services.table_components.download'),

            Column::make(__('messages.common.action'), 'id')
                ->view('services.table_components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        $query = Services::query()->select('services.*');

        return $query;
    }
}
