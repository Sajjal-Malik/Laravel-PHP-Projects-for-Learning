<?php

namespace App\Http\Controllers;

use App\DataTables\CompanyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{

    protected CompanyRepositoryInterface $companyRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo)
    {
        $this->companyRepo = $companyRepo;
    }

    public function index(CompanyDataTable $dataTable)
    {
        try {
            $view = 'admin.companies.index';

            return $dataTable->render($view);

        } catch (\Exception $e) {

            Log::error('Companies list load error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to load companies.']);
        }
    }

    public function create()
    {
        try {
            return view('admin.companies.create');
        } catch (\Exception $e) {
            Log::error('Company details load error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load company details.'])->withInput();
        }
    }

    public function store(CompanyRequest $request)
    {
        try {
            $data = $request->all();

            $this->companyRepo->store([
                ...$request->all(),
                'logo' => $request->file('logo')
            ]);

            $this->companyRepo->store($data);

            return redirect()->route('companies.index')->with('success', 'Company created');
        } catch (\Exception $e) {

            Log::error('Company creation error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to create company.'])->withInput();
        }
    }

    public function show(int $id)
    {
        try {
            $company = $this->companyRepo->find($id);

            return view('admin.companies.show', compact('company'));
        } catch (\Exception $e) {

            Log::error('Company details load error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to load company details.'])->withInput();
        }
    }

    public function edit(int $company)
    {
        try {
            $company = $this->companyRepo->find($company);

            return view('admin.companies.edit', compact('company'));
        } catch (\Exception $e) {

            Log::error('Company edit form load error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to load edit company form.'])->withInput();
        }
    }

    public function update(CompanyRequest $request, int $company)
    {
        try {
            $data = [...$request->except(['_token', '_method', 'logo']),];
            
            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo');
            }

            $this->companyRepo->update($company, $data);

            return redirect()->route('companies.index')->with('success', 'Company updated');

        } catch (\Exception $e) {

            Log::error('Company update error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to update company.'])->withInput();
        }
    }

    public function destroy(int $company)
    {
        try {
            $this->companyRepo->delete($company);

            return redirect()->route('admin.companies.index')->with('success', 'Company Deleted');
        } catch (\Exception $e) {

            Log::error('Company deletion error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to update company.'])->withInput();
        }
    }
}
