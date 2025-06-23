<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Mail\EmployeeCreatedMail;
use App\Models\Company;
use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function __construct(private EmployeeRepositoryInterface $employeeRepo) {}

    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $data = $this->employeeRepo->all();
    
                return DataTables::of($data)
                    ->addColumn('empPhoto', function ($row) {
                        if ($row->empPhoto) {
                            $url = asset('storage/' . $row->empPhoto);
                            return '<img src="' . $url . '" alt="Photo" width="80" height="70" style="border-radius: 50%;">';
                        }
                        return 'N/A';
                    })
                    ->addColumn('company', fn($row) => $row->company?->name ?? 'N/A')
                    ->addColumn(
                        'action',
                        fn($row) =>
                        view('employees.buttons.actions', compact('row'))->render()
                    )
                    ->rawColumns(['empPhoto', 'action'])
                    ->make(true);
            }
    
            return view('employees.index');
        }
        catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load employees.'])->withInput();
        }
    }

    public function create()
    {
        try {
            $companies = Company::all();
            return view('employees.create', compact('companies'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load create employee form.'])->withInput();
        }
    }

    public function store(EmployeeRequest $request)
    {
        
        try {

            $this->employeeRepo->store(
                $request->validated() + ['empPhoto' => $request->file('empPhoto')]
            );

            return redirect()->route('employees.index')->with('success', 'Employee created successfully.');

        } catch (\Exception $e) {
            
            return back()->withErrors(['error' => 'Failed to create employee.'])->withInput();
        }
    }

    public function show($id)
    {
        try{
            $employee = $this->employeeRepo->find($id);
            if (is_string($employee)) 
                return abort(404);
            return view('employees.show', compact('employee'));
        }
        catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load employee details.'])->withInput();
        }
    }

    public function edit($id)
    {
        try{
            $employee = $this->employeeRepo->find($id);
            if (is_string($employee)) return abort(404);
    
            $companies = Company::all();
            return view('employees.edit', compact('employee', 'companies'));
        }
        catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load edit employee form.'])->withInput();
        }
    }

    public function update(EmployeeRequest $request, $id)
    {
        
        try {
            DB::beginTransaction();

            $this->employeeRepo->update(
                $id,
                $request->validated() + ['empPhoto' => $request->file('empPhoto')]
            );

            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update employee.'])->withInput();
        }
    }

    public function destroy($id)
    {
        
        try {
            DB::beginTransaction();
            
            $this->employeeRepo->delete($id);
            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('employees.index')->with('error', 'Failed to delete employee.');
        }
    }
}
