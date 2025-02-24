<?php

namespace App\DataTables;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LanguageDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                $editBtn = "<a href='" . route('admin.languages.edit', $query->id) . "' class='btn btn-primary'><i class='far fa-edit'></i></a>";
                $deleteBtn = "<a href='" . route('admin.languages.destroy', $query->id) . "' class='btn btn-danger ml-2 delete-item'><i class='fas fa-trash-alt'></i></a>";
                return $editBtn . $deleteBtn;
            })

            ->addColumn('status', function ($query) {
                $badgeClass = $query->status ? 'badge-success' : 'badge-danger';
                $statusText = $query->status ? 'Active' : 'Inactive';

                return "<span class='badge $badgeClass'>$statusText</span>";
            })
            ->addColumn('is_default', function ($query) {
                $badgeClass = $query->is_default ? 'badge-primary' : 'badge-secondary';
                $defaultText = $query->is_default ? 'Default' : 'No';

                return "<span class='badge $badgeClass'>$defaultText</span>";
            })
            ->rawColumns(['status', 'action', 'is_default'])

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Language $model): QueryBuilder
    {
        return $model->newQuery()->select(['id', 'name', 'language', 'slug', 'status', 'is_default']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('language-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('#')
                ->width(50)
                ->addClass('text-center fw-bold'),
            Column::make('name')->title('Name'),
            Column::make('language')->title('Language'),
            Column::make('slug')->title('Slug'),
            Column::make('status')->title('Status'),
            Column::make('is_default')->title('Default Language'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Language_' . date('YmdHis');
    }
}
