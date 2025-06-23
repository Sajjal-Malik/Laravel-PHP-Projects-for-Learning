<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    public function __construct(private CompanyRepositoryInterface $companyRepo) {}

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $this->companyRepo->all();

                return DataTables::of($data)
                    ->addColumn('logo', function ($row) {
                        if ($row->logo) {
                            $url = asset('storage/' . $row->logo);
                            return '<img src="' . $url . '" alt="Logo" width="60" height="60">';
                        }
                        return 'N/A';
                    })
                    ->addColumn('action', function ($row) {
                        return view('companies.buttons.actions', compact('row'))->render();
                    })
                    ->rawColumns(['logo', 'action'])
                    ->make(true);
            }

            return view('companies.index');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load companies.'])->withInput();
        }
    }

    public function create()
    {
        try {

            return view('companies.create');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load create company form.'])->withInput();
        }
    }

    public function store(CompanyRequest $request)
    {
        
        try {
            $this->companyRepo->store(
                $request->validated() + ['logo' => $request->file('logo')]
            );

            
            return redirect()->route('companies.index')->with('success', 'Company created successfully.');
        } catch (\Exception $e) {

            return back()->withErrors(['error' => 'Failed to create company.'])->withInput();
        }
    }

    public function show($id)
    {
        try {

            $company = $this->companyRepo->find($id);

            if (is_string($company))
                return abort(404);

            return view('companies.show', compact('company'));
        } catch (\Exception $e) {

            return back()->withErrors(['error' => 'Failed to load company details.'])->withInput();
        }
    }

    public function edit($id)
    {
        try {

            $company = $this->companyRepo->find($id);

            if (is_string($company))
                return abort(404);

            return view('companies.edit', compact('company'));
        } catch (\Exception $e) {

            return back()->withErrors(['error' => 'Failed to load edit company form.'])->withInput();
        }
    }

    public function update(CompanyRequest $request, $id)
    {
        try {
            $this->companyRepo->update(
                $id,
                $request->validated() + ['logo' => $request->file('logo')]
            );

            return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
        } catch (\Exception $e) {

            return back()->withErrors(['error' => 'Failed to update company.'])->withInput();
        }
    }

    public function destroy($id)
    {
        try {

            $this->companyRepo->delete($id);

            return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
        } catch (\Exception $e) {

            return redirect()->route('companies.index')->with('error', 'Failed to delete company.');
        }
    }
}
