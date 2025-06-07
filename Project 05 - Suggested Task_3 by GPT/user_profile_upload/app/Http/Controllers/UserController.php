<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $users = User::select('id', 'firstName', 'lastName', 'email', 'age', 'phoneNumber', 'bio', 'DOB', 'profileImage', 'createdAt', 'updatedAt');

                return DataTables::of($users)
                    ->addColumn('profileImage', function ($row) {
                        return '<img src="' . asset('storage/' . ($row->profileImage ?? 'default.png')) . '" width="50" class="rounded">';
                    })
                    ->addColumn('actions', function ($row) {
                        return '
                        <button class="btn btn-sm btn-info viewUser" data-id="' . $row->id . '"><i class="fa fa-eye"></i></button>
                        <button class="btn btn-sm btn-warning editUser" data-id="' . $row->id . '"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger deleteUser" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>
                    ';
                    })
                    ->rawColumns(['profileImage', 'actions'])
                    ->make(true);
            }

            return view('users.index');
        } catch (\Exception $e) {

            Log::error('User index error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['error' => 'Something went wrong.'], 500);
            }

            return back()->withErrors(['error' => 'Unable to load user list.']);
        }
    }
}
