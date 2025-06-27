<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\DataTables\EmployeeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepo;
    protected CompanyRepositoryInterface $companyRepo;

    public function __construct(UserRepositoryInterface $userRepo, CompanyRepositoryInterface $companyRepo)
    {
            $this->userRepo = $userRepo;
            $this->companyRepo = $companyRepo;
    }

    public function index(UserDataTable $dataTable)
    {
        try{
            
            return $dataTable->render('admin.users.index');
        }
        catch(Exception $e){

            Log::error('User list load error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to load users.']);
        }
    }

    public function create()
    {
        try{
            return view('auth.register');
        }
        catch(Exception $e){

            Log::error('Registration form error' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Failed to load user Registration Form.']);
        }
    }

    public function store(EmployeeRequest $request)
    {
        try {

            $user = $this->userRepo->store($request->only([
                'firstName',
                'lastName',
                'userName',
                'email',
                'password',
                'password_confirmation'
            ]));

            if (!$user) {
                return redirect()->back()->with('error', 'User could not be created.');
            }

            return redirect()->route('users.index')->with('success', 'User created Successfully');

        } catch (Exception $e) {

            Log::error('User store error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to create user'])->withInput();
        }
    }

    public function toggleBlock($id)
    {
        try {
            $user = $this->userRepo->toggleBlock($id);

            return response()->json(['success' => true,'status'  => $user->status]);

        } catch (Exception $e) {

            Log::error('Toggle block error: ' . $e->getMessage());

            return response()->json(['success' => false], 500);
        }
    }

    public function employeeIndex(EmployeeDataTable $dataTable)
    {
        try{

            return $dataTable->render('admin.users.employees.index');
        }
        catch(Exception $e){

            Log::error('Employee list load error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to load employees.']);
        }
    }

    public function employeeCreate()
    {
        try{
            $companies = $this->companyRepo->all();

            return view('admin.users.employees.create', compact('companies'));
        }
        catch(Exception $e){

            Log::error('Creation form error' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Failed to load Employee creation Form.']);
        }
    }

    public function employeeStore(EmployeeRequest $request)
    {
        try {
            $this->userRepo->storeEmployee($request->all());

            return redirect()->route('employees.index')->with('success', 'Employee created');

        } catch (Exception $e) {

            Log::error('Employee store error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to create employee'])->withInput();
        }
    }

    public function employeeShow($id)
    {
        try{
            $employee = $this->userRepo->find($id);
    
            return view('admin.users.employees.show', compact('employee'));
        }
        catch(Exception $e){
            Log::error('Employe not shown' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to load Employee details');
        }
    }

    public function employeeEdit($id)
    {
        try{
            $employee = $this->userRepo->find($id);
            $companies = $this->companyRepo->all();
            
            return view('admin.users.employees.edit', compact('employee', 'companies'));
        }
        catch(Exception $e){
            
            Log::error('Edit form error' . $e->getMessage());

            return redirect()->route('employees.edit')->with('error', 'Error Loading Edit form');
        }
    }

    public function employeeUpdate(EmployeeRequest $request, $id)
    {
        try {
            $this->userRepo->updateEmployee($id, $request->all());

            return redirect()->route('employees.index')->with('success', 'Employee updated');
        } catch (Exception $e) {
            Log::error('Employee update error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to update employee'])->withInput();
        }
    }

    public function employeeDestroy($id)
    {
        try {
            $this->userRepo->deleteEmployee($id);

            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');

        } catch (Exception $e) {

            Log::error('Employee deletion error: ' . $e->getMessage());

            return redirect()->route('employees.index')->with('error', 'Failed to delete employee.');
        }
    }
}
