<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($u) {
                
                return view('admin.users.actions', compact('u'))->render();
            })
            ->editColumn('status', function ($u) {
                return $u->status === 'Blocked'
                    ? '<span class="badge bg-danger">Blocked</span>'
                    : '<span class="badge bg-success">Active</span>';
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'asc');
    }

    protected function getColumns(): array
    {
        return [
            Column::make('id')->title('#'),
            Column::make('firstName')->title('First Name'),
            Column::make('lastName')->title('Last Name'),
            Column::make('email'),
            Column::make('role'),
            Column::make('status')->orderable(false),
            Column::computed('action')->exportable(false)->printable(false)
            ->orderable(false)->searchable(false),
        ];
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
