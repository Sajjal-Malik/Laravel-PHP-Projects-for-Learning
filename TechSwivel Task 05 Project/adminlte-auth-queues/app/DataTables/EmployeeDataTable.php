<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('empPhoto', function ($e) {
                return $e->empPhoto
                    ? '<img src="'.asset('storage/employee-photos/'.$e->empPhoto).'" width="45" class="rounded-circle">'
                    : '-';
            })
            ->addColumn('company', fn($e) => optional($e->company)->name)
            ->addColumn('action', function ($row) {
                return view('admin.users.employees.buttons.actions', compact('row'))->render();
            })
            ->rawColumns(['empPhoto', 'action'])
            ->setRowId('id');
    }

    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->where('role', 2);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('employees-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc');
    }

    protected function getColumns(): array
    {
        return [
            Column::computed('empPhoto')
                  ->exportable(false)->printable(false)
                  ->orderable(false)->searchable(false)
                  ->title('Photo'),
            Column::make('firstName')->title('First'),
            Column::make('lastName')->title('Last'),
            Column::computed('company')->title('Company'),
            Column::make('email'),
            Column::make('phone'),
            Column::computed('action')
                  ->exportable(false)->printable(false)
                  ->orderable(false)->searchable(false)
                  ->title('Actions'),
        ];
    }

    protected function filename(): string
    {
        return 'Employees_' . date('YmdHis');
    }
}
