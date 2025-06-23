<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Events\UserCreated;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $this->userRepo->all();

                return DataTables::of($data)
                    ->addColumn('role', fn($row) => $row->role == 1 ? 'Admin' : 'User')
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
            return response()->json(['success' => false, 'message' => 'Users list could not be loaded.']);
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
            return redirect()->back()->with('error', 'Server Error | Register Page Not Found');
        }
    }

    public function store(Request $request)
    {
        
        try {
            $user = $this->userRepo->store($request->only([
                'name',
                'email',
                'password',
                'password_confirmation'
            ]));

            if (!$user) {
                return redirect()->back()->with('error', 'User could not be created | Validation Error');
            }

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {

            Log::error('User creation failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'User could not be created | Server Error');
        }
    }
}
