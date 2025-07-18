<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserManagementRepositoryInterface;
use App\Http\Requests\RiderRequest;
use Exception;
use SebastianBergmann\Type\TrueType;

class RiderController extends Controller
{
    protected $userRepo;

    public function __construct(UserManagementRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * GET list of Rider and Display from Resource
     * @return Factory|View|RedirectResponse
     */
    public function index()
    {
        try {
            $riders = $this->userRepo->getAllRiders();

            return view('admin.riders.index', compact('riders'));

        } catch (Exception $e) {

            return back()->with('error', 'Something went wrong while fetching riders.');
        }
    }

    /**
     * Load the View to Create Rider
     */
    public function create()
    {
        try{
            return view('admin.riders.create');
        }
        catch(Exception $e){

            return view('admin.dashboard')->with('error', 'Failed to load Rider Create Page');
        }
    }

    /**
     * Store the Rider Data and Redirect required View
     * @return RedirectResponse
     */
    public function store(RiderRequest $request)
    {
        try {
            $this->userRepo->storeRider($request->all());

            return redirect()->route('admin.riders.index')->with('success', 'Rider created successfully.');

        } catch (Exception $e) {

            return back()->withInput()->with('error', 'Failed to create rider.');
        }
    }
}
