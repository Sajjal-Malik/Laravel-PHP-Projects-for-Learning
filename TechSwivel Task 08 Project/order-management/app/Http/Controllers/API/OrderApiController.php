<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditOrderRequest;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\GetAllOrderRequest;
use App\Http\Requests\OrderSyncRequest;
use App\Http\Requests\RiderOrderUpdateRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    protected $orderRepo;
    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    /**
     * Update Status of Order by Rider only.
     * @return mixed|JsonResponse
     */
    public function updateOrder(RiderOrderUpdateRequest $riderOrderUpdateRequest)
    {
        try {
            $order = $this->orderRepo->updateOrderStatusByRider($riderOrderUpdateRequest->all());

            return response()->json([
                'message' => "Order updated Successfully",
                'order' =>  new OrderResource($order),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => "Failed to update Order status",
                'detail' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET All User Order Status
     * @return mixed|OrderCollection|JsonResponse
     */
    public function getAllOrders(GetAllOrderRequest $getAllOrderRequest)
    {
        try {
            $orders = $this->orderRepo->getAllUserOrders($getAllOrderRequest->query('status'), auth()->user());

            return new OrderCollection($orders);
            
        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => "Failed to GET Order Status",
                'detail' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get Specific Order Details
     * @return mixed|JsonResponse
     */
    public function getOrderDetail($orderId)
    {
        try {
            $order = $this->orderRepo->getOrderById($orderId);

            return response()->json([
                'order' => new OrderResource($order)
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'Order not found',
                'details' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Edit Pending Order Description
     * @return mixed|JsonResponse
     */
    public function editPendingOrder($orderId, EditOrderRequest $editOrderRequest)
    {
        try {
            $order = $this->orderRepo->editPendingOrder($orderId, $editOrderRequest->all(), auth()->user());

            return response()->json([
                'message' => 'Order Edited Successfully',
                'order' => new OrderResource($order)
            ]);
        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'Order Edit Failed',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Customer Submits Feeback and Order COMPLETES
     * @return mixed|JsonResponse
     */
    public function submitFeedback(FeedbackRequest $feedbackRequest)
    {
        try {
            $order = $this->orderRepo->submitFeedback($feedbackRequest->all());

            return response()->json([
                'message' => 'Feedback submitted. Order marked as COMPLETED.',
                'order' => new OrderResource($order)
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'Feedback failed',
                'detail' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Order Data Sync to Firestore Collections
     * @return mixed|JsonResponse
     */
    public function sync(OrderSyncRequest $orderSyncRequest)
    {
        try{
            $order = $this->orderRepo->syncFromFirestore($orderSyncRequest->all());
    
            return response()->json([
                'success' => true,
                'message' => "Order Synced Successfully",
                'order' => $order
            ], 200);
        }
        catch(Exception $e){
            
             return response()->json([
                'error' => true,
                'message' => 'Order sync failed.',
                'detail' => $e->getMessage()
            ], 500);
        }
    }
}
