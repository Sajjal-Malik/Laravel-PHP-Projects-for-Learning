<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {

        try {

            if ($request->ajax()) {

                $data = User::select(['id', 'name', 'email', 'role', 'isActive']);

                return DataTables::of($data)
                    ->addColumn('role', function ($row) {
                        return $row->role == 1 ? 'Admin' : 'User';
                    })
                    ->addColumn('status', function ($row) {
                        return $row->isActive ? 'Active' : 'Blocked';
                    })
                    ->addColumn('action', function ($row) {
                        $btnClass = $row->isActive ? 'btn-danger' : 'btn-success';
                        $btnText = $row->isActive ? 'Block' : 'Unblock';
                        return '<button class="btn ' . $btnClass . ' toggle-status" data-id="' . $row->id . '">' . $btnText . '</button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('users.index');
            
        } catch (\Exception $e) {

            Log::error('Users list failed to load: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to show users list']);
        }
    }

    public function toggleBlock($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->isActive = !$user->isActive;

            $user->save();

            return response()->json(['success' => true, 'message' => 'User status updated.']);

        } catch (\Exception $e) {
            
            Log::error('User block/unblock failed: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to update user status.']);
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

            DB::beginTransaction();

            $newUser = new CreateNewUser();

            $user = $newUser->create($request->only(['name', 'email', 'password', 'password_confirmation']));

            if ($request->has('roles')) {
                $user->roles()->sync($request->roles);
            }

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User Created Successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'User Could not be Created | Server Error');
        }
    }
}
