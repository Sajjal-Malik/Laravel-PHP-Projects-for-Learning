<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Services\DataTable;

class ProfileDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable($query): \Yajra\DataTables\DataTableAbstract
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('fullName', function ($row) {
                return $row->firstName . ' ' . $row->lastName;
            })
            ->addColumn('picture', function ($row) {
                if ($row->picture) {
                    return '<img src="' . asset('storage/' . $row->picture) . '" width="40" height="40" class="rounded-circle">';
                }
                return 'N/A';
            })
            ->editColumn('dob', function ($row) {
                return Carbon::parse($row->dob)->format('Y-m-d');
            })
            ->addColumn('ageStatus', function ($row) {
                return $row->ageStatus?->value ?? 'N/A';
            })
            ->addColumn('action', function ($row) {
                return view('admin.profiles.partials.actions', compact('row'))->render();
            })
            ->rawColumns(['picture', 'action']);
    }

    /**
     * Get the query object to be processed by DataTables.
     */
    public function query(Profile $model): Builder
    {
        return $model->newQuery()->latest('createdAt');
    }

    /**
     * Optional: HTML configuration (used for DOM rendering).
     */
    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()
            ->setTableId('profiles-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->buttons(['reload', 'reset']);
    }

    /**
     * Define the columns for DataTable.
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'id', 'name' => 'id', 'title' => '#'],
            ['data' => 'picture', 'name' => 'picture', 'title' => 'Picture', 'orderable' => false, 'searchable' => false],
            ['data' => 'fullName', 'name' => 'fullName', 'title' => 'Full Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'dob', 'name' => 'dob', 'title' => 'Date of Birth'],
            ['data' => 'gender', 'name' => 'gender', 'title' => 'Gender'],
            ['data' => 'age', 'name' => 'age', 'title' => 'Age'],
            ['data' => 'ageStatus', 'name' => 'ageStatus', 'title' => 'Age Status'],
            ['data' => 'phoneNumber', 'name' => 'phoneNumber', 'title' => 'Phone'],
            ['data' => 'bio', 'name' => 'bio', 'title' => 'BIO'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Actions', 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Filename for export (if export buttons are enabled).
     */
    protected function filename(): string
    {
        return 'Profile_' . date('YmdHis');
    }
}
