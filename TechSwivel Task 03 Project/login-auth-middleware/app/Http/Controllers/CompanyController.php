<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Company::select(['id', 'name', 'email', 'website', 'logo']);

                return DataTables::of($data)

                    ->addColumn('logo', function ($row) {
                        if ($row->logo) {
                            return '<img src="' . asset('storage/' . $row->logo) . '" width="50" height="50">';
                        } else {
                            return '<span class="text-muted">No Logo</span>';
                        }
                    })

                    // Action buttons from Blade partial
                    ->addColumn('action', function ($row) {
                        return view('companies.buttons.actions', compact('row'))->render();
                    })

                    ->rawColumns(['logo', 'action']) // Allow HTML rendering in these columns
                    ->make(true);
            }

            return view('companies.index');
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Something went wrong while loading companies.',
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

            return view('companies.create');
        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'Something went wrong while loading companies.',
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
            'name' => "required|string|max:255",
            'email' => "nullable|email|max:255",
            'website' => "nullable|url|max:255",
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=100,min_height=100|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')->store('logos', 'public');
            }

            Company::create($validated);

            DB::commit();

            return redirect()->route('companies.index')->with('success', 'Company created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Failed to create company: " . $e->getMessage());

            return back()->withErrors(['error' => "Failed to create company, please try again."])->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $company = Company::findOrFail($id);

            return view('companies.show', compact('company'));
        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'Something went wrong while showing a company data.',
                'detail' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {

            $company = Company::findOrFail($id);

            return view('companies.edit', compact('company'));
        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'Something went wrong while loading companies data for editing.'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=100,min_height=100|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $company = Company::findOrFail($id);

            // Handle new logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                    Storage::disk('public')->delete($company->logo);
                }

                $validated['logo'] = $request->file('logo')->store('logos', 'public');
            }

            $company->update($validated);

            DB::commit();

            return redirect()->route('companies.index')->with('success', 'Company updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to update company: ' . $e->getMessage());

            return back()->withInput()->withErrors(['error' => 'Failed to update company. Please try again']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $company = Company::findOrFail($id);

            $company->delete();

            DB::commit();

            return redirect()->route('companies.index')->with('success', 'Company deleted successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Failed to delete company: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Failed to delete company.']);
        }
    }
}
