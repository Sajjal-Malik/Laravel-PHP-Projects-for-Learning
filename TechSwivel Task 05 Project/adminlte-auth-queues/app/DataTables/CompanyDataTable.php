<?php

namespace App\DataTables;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CompanyDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('logo', function ($company) {
                return $company->logo
                    ? '<img src="' . asset('storage/company-logos/' . $company->logo) . '" width="60">'
                    : '-';
            })
            ->addColumn('action', function ($row) {

                return view('admin.companies.buttons.actions', compact('row'))->render();
            })
            ->rawColumns(['logo', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Company $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('companies-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'asc');
    }

    /**
     * Get the dataTable columns definition.
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title('#'),
            Column::make('name'),
            Column::make('email'),
            Column::make('website'),
            Column::computed('logo')->exportable(false)->printable(false),
            Column::computed('action')->exportable(false)->printable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Company_' . date('YmdHis');
    }
}
