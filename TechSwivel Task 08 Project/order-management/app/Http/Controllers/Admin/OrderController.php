<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\OrderRequest;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Exception;

class OrderController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    /**
     * Get list of All Orders to View
     * @return Factory|View|RedirectResponse
     */
    public function index()
    {
        try {
            $orders = $this->orderRepo->getAll();

            return view('admin.orders.index', compact('orders'));
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'Failed to Load Orders');
        }
    }

    /**
     * Load Order Create View
     * @return  Factory|View|RedirectResponse
     */
    public function create()
    {
        try {
            $riders = $this->orderRepo->getRiders();

            $customers = $this->orderRepo->getCustomers();

            return view('admin.orders.create', compact('riders', 'customers'));
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'Failed to load Order create View');
        }
    }

    /**
     * Store Order and Redirect to View
     * @return RedirectResponse
     */
    public function store(OrderRequest $request)
    {
        try {
            $this->orderRepo->create($request->all());

            return redirect()->route(route: 'admin.orders.index')->with('success', 'Order created and rider notified.');
        } catch (Exception $e) {

            return back()->with('error', 'Something went wrong.');
        }
    }
}
