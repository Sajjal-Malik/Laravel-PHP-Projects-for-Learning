<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
                        return '<img src="' . asset('storage/' . ($row->profileImage ?? 'default.jpg')) . '" width="50" class="rounded">';
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

    public function create(){
        try{
            return view('users.create');
        }
        catch(\Exception $e){

            Log::error('User create Error'. $e->getMessage());

            return response()->json(['error' => 'Failed to load create user form'], 500);
        }
    }

    public function store(StoreUserRequest $request){

        try{

             // 1. Upload image if present
             $profileImagePath = null;
            if($request->hasFile('profileImage')){
                $profileImagePath = $request->file('profileImage')->store('uploads', 'public');
            }

            // 2. create user
            $user = User::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'age' => $request->age,
                'phoneNumber' => $request->phoneNumber,
                'bio' => $request->bio,
                'DOB' => $request->DOB,
                'profileImage' => $profileImagePath
            ]);

            return response()->json([
                'message' => 'User created successfully',
                'user' => $user
            ]);
        }   
        catch(\Exception $e){

            Log::error('User store error' . $e->getMessage());

            return response()->json([
                'error' => 'Something went wrong, Please try again.'
            ]);
        }

    }
}
