<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepo;
    private CompanyRepositoryInterface $companyRepo;

    public function __construct(UserRepositoryInterface $userRepo, CompanyRepositoryInterface $companyRepo)
    {
        $this->userRepo = $userRepo;
        $this->companyRepo = $companyRepo;
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $this->userRepo->all();

                return DataTables::of($data)
                    ->addColumn('role', fn($row) => $row->role == 1 ? 'Admin' : 'Employee')
                    ->addColumn('status', fn($row) => $row->isBlocked ? 'Blocked' : 'Active')
                    ->addColumn('action', function ($row) {
                        $btnClass = $row->isBlocked ? 'btn-success' : 'btn-danger';
                        $btnText = $row->isBlocked ? 'Unblock' : 'Block';
                        return '<button class="btn ' . $btnClass . ' toggle-status" data-id="' . $row->id . '">' . $btnText . '</button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('users.index');
        } catch (\Exception $e) {
            Log::error('Users list load error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Users list could not be loaded.']);
        }
    }

    public function toggleBlock($id)
    {
        try {
            $this->userRepo->toggleBlock($id);
            return response()->json(['success' => true, 'message' => 'User status updated.']);
        } catch (\Exception $e) {
            Log::error('User block toggle error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'User status update failed.']);
        }
    }

    public function create()
    {
        try {
            return view('auth.register');
        } catch (\Exception $e) {
            Log::error('User creation form load error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load user creation form.']);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = $this->userRepo->store($request->only([
                'firstName',
                'lastName',
                'email',
                'password',
                'password_confirmation'
            ]));

            if (!$user) {
                return redirect()->back()->with('error', 'User could not be created.');
            }

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'User could not be created.');
        }
    }


    public function employeeIndex(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $this->userRepo->getEmployees();

                return DataTables::of($data)
                    ->addColumn('empPhoto', function ($row) {
                        if ($row->empPhoto) {
                            $url = asset('storage/' . $row->empPhoto);
                            return '<img src="' . $url . '" alt="Photo" width="70" height="70" style="border-radius: 50%;">';
                        }
                        return 'N/A';
                    })
                    ->addColumn('company', fn($row) => $row->company?->name ?? 'N/A')
                    ->addColumn(
                        'action',
                        fn($row) =>
                        view('users.employees.buttons.actions', compact('row'))->render()
                    )
                    ->rawColumns(['empPhoto', 'action'])
                    ->make(true);
            }

            return view('users.employees.index');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load employees.']);
        }
    }

    public function employeeCreate()
    {
        try {
            $companies = $this->companyRepo->all();

            return view('users.employees.create', compact('companies'));

        } catch (\Exception $e) {

            Log::error('Employee creation form load error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to load employee creation form.']);
        }
    }

    public function employeeStore(EmployeeRequest $request)
    {
        try {
            $this->userRepo->storeEmployee([
                ...$request->all(),
                'empPhoto' => $request->file('empPhoto')
            ]);

            return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create employee.']);
        }
    }

    public function employeeShow($id)
    {
        try {
            $employee = $this->userRepo->find($id);

            if (is_string($employee))
                return abort(404);

            return view('users.employees.show', compact('employee'));
        } catch (\Exception $e) {

            Log::error('Employee details load error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to load employee details.']);
        }
    }

    public function employeeEdit($id)
    {
        try {
            $employee = $this->userRepo->find($id);
            if (is_string($employee)) return abort(404);

            $companies = $this->companyRepo->all();
            return view('users.employees.edit', compact('employee', 'companies'));
        } catch (\Exception $e) {

            Log::error('Employee edit form load error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to load employee edit form.']);
        }
    }

    public function employeeUpdate(EmployeeRequest $request, $id)
    {
        try {
            $this->userRepo->updateEmployee($id, [
                ...$request->all(),
                'empPhoto' => $request->file('empPhoto')
            ]);

            return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
        } catch (\Exception $e) {
            Log::error('Employee update error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update employee.']);
        }
    }

    public function employeeDestroy($id)
    {
        try {
            $this->userRepo->deleteEmployee($id);
            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Employee deletion error: ' . $e->getMessage());
            return redirect()->route('employees.index')->with('error', 'Failed to delete employee.');
        }
    }
}
