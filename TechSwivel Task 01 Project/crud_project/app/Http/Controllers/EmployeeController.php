<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Employee::with('company')->select('employees.*');

                return DataTables::of($data)

                    ->addColumn('company.name', function ($row) {
                        return $row->company ? $row->company->name : 'N/A';
                    })
                    ->addColumn('action', function ($row) {
                        return view('employees.buttons.actions', compact('row'))->render();
                    })
                    ->make(true);
            }
            return view('employees.index');

        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'Something went wrong while loading employees.',
                'detail' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {

            $companies = Company::all();

            return view('employees.create', compact('companies'));

        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'Something went wrong while loading employees.',
                'detail' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'companyId' => 'nullable|exists:companies,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        try{

            DB::beginTransaction();

            Employee::create($validated);

            DB::commit();

            return view('employees.index')->with('success', 'Employee created Successfylly');
        }
        catch(\Exception $e){

            DB::rollBack();

            Log::error("Failed to create Employee" . $e->getMessage());

            return back()->withErrors(['error' => 'Something went wrong'])->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{

            $employee = Employee::with('company')->findOrFail($id);

            return view('employees.show', compact('employee'));
        }
        catch(\Exception $e){

            return response()->json([
                    'error' => true,
                    'message' => 'Something went wrong while showing an employee data.',
                    'detail' => $e->getMessage()
                ], 500);

        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{

            $employee = Employee::findOrFail($id);
    
            $companies = Company::all();
    
            return view('employees.edit', compact('employee', 'companies'));
        }
        catch(\Exception $e){

            return response()->json([
                'error' => true,
                'message' => 'Something went wrong while loading employees data for editing.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'companyId' => 'nullable|exists:companies,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        try{

            DB::beginTransaction();

            $employee = Employee::findOrFail($id);
            $employee->update($validated);

            DB::commit();

            return redirect()->route('employees.index')->with('success', 'Employee updated Successfully');
        }
        catch(\Exception $e){

            DB::rollBack();

            Log::error("Failed to update Employee" . $e->getMessage());

            return back()->withErrors(['error' => 'Something went wrong'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

            DB::beginTransaction();

            $employee = Employee::findOrFail($id);

            $employee->delete();

            DB::commit();

            return redirect()->route('employees.index')->with('success', 'Employee deleted Successfully');
        }   
        catch(\Exception $e){
            
            DB::rollBack();
    
            Log::error('Failed to delete employee: ' . $e->getMessage());
    
            return redirect()->back()->withErrors(['error' => 'Failed to delete Employee']);

        }

    }
}
