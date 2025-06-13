<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            if ($request->ajax()) {

                $data = User::select(['id', 'firstName', 'lastName', 'email', 'age', 'phoneNumber', 'bio', 'dob']);

                return DataTables::of($data)

                    ->addColumn('action', function ($row) {

                        return view('users.buttons.actions', compact('row'))->render();
                    })

                    ->make(true);
            }

            return view('users.index');

        } catch (\Exception $e) {

            return response()->json(['message' => 'Something went wrong!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        try {

            $data = $request->all();

            $data['password'] = Hash::make($data['password']);

            User::create($data);

            DB::commit();

            return response()->json(['message' => 'User created successfully']);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json(['message' => 'User creation failed!', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $user = User::findOrFail($id);

            return response()->json($user);

        } catch (\Exception $e) {

            return response()->json(['message' => 'User not found!', 'error' => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json($user);

        } catch (\Exception $e) {

            return response()->json(['message' => 'User not found!', 'error' => $e->getMessage()], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            $data = $request->validated();

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);

            DB::commit();

            return response()->json(['message' => 'User updated successfully']);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json(['message' => 'User update failed!', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            $user->delete();

            DB::commit();

            return response()->json(['message' => 'User deleted successfully']);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json(['message' => 'User deletion failed!', 'error' => $e->getMessage()], 500);
        }
    }
}
