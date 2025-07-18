<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserManagementRepositoryInterface;
use App\Http\Requests\CustomerRequest;
use Exception;

class CustomerController extends Controller
{
    protected $userRepo;

    public function __construct(UserManagementRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * GET list of Customer and Display from Resource
     * @return Factory|View|RedirectResponse
     */
    public function index()
    {
        try {
            $customers = $this->userRepo->getAllCustomers();

            return view('admin.customers.index', compact('customers'));

        } catch (Exception $e) {

            return back()->with('error', 'Something went wrong while fetching customers.');
        }
    }

    /**
     * Load the view to Create Customer with Riders
     * @return Factory|View|RedirectResponse
     */
    public function create()
    {
        try {
            $riders = $this->userRepo->getAllRiders();

            return view('admin.customers.create', compact('riders'));

        } catch (Exception $e) {

            return back()->with('error', 'Failed to load rider list.');
        }
    }

    /**
     * Store the Customer Data and Redirect required View
     * @return RedirectResponse
     */
    public function store(CustomerRequest $request)
    {
        try {
            $this->userRepo->storeCustomer($request->all());

            return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully.');

        } catch (Exception $e) {

            return back()->withInput()->with('error', 'Failed to create customer.');
        }
    }
}
