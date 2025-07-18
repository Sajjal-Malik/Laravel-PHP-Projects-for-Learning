<?php

namespace App\Repositories\Repository;

use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Notifications\OrderCreatedNotification;
use Exception;
use Kreait\Firebase\Contract\Firestore;
use Kreait\Laravel\Firebase\Facades\Firebase;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * List all Orders from DB
     * @return array|Collection
     */
    public function getAll()
    {
        try {

            return Order::with(['rider', 'customer'])->latest()->get();
        } catch (Exception $e) {

            Log::error('Failed to load Orders ' . $e->getMessage());

            throw new Exception('Failed to get Orders ' . $e->getMessage());
        }
    }

    /**
     * Get Rider Data
     * @return User|Collection
     */
    public function getRiders()
    {
        try {
            return User::where('role', User::RIDER)->get();
        } catch (Exception $e) {

            throw new Exception('Failed to get Riders ' . $e->getMessage());
        }
    }

    /**
     * Get Customer Data
     * @return User|Collection 
     */
    public function getCustomers()
    {
        try {
            return User::where('role', User::CUSTOMER)->get();
        } catch (Exception $e) {

            throw new Exception('Failed to get Riders ' . $e->getMessage());
        }
    }

    /**
     * Create Order and Store data in DB
     * @return Order|Model
     */
    public function create(array $data)
    {
        try {

            DB::beginTransaction();

            $order = Order::create([
                'riderId' => $data['riderId'],
                'customerId' => $data['customerId'],
                'status' => OrderStatus::PENDING,
                'description' => $data['description'],
            ]);


            $rider = User::find($data['riderId']);
            $rider->notify(new OrderCreatedNotification($order));

            DB::commit();

            return $order;
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Order Creation Failed: ' . $e->getMessage());

            throw new Exception('Failed to Create Order ' . $e->getMessage());
        }
    }

    /**
     * Order Status Update by Rider
     * @return Order|Model
     */
    public function updateOrderStatusByRider(array $data)
    {
        try {
            DB::beginTransaction();

            $order = Order::where('id', $data['orderId'])->where('riderId', auth()->user()->id)
                ->firstOrFail();


            $order->update([
                'status' => $data['status']
            ]);

            if ($order->status::DELIVERED) {
                throw new Exception("Order Status will be COMPLETED after Customer Feedback, Your JOB is DONE");
            }

            $firestore = app(Firestore::class);

            $firestore->database()->collection('orders')->document((string)$order->id)->set([
                'riderName' => $order->rider?->name,
                'customerName' => $order->customer?->name,
                'status' => $order->status->value,
                'updatedAt' => now()->toDateTimeString()
            ]);

            DB::commit();

            return $order;
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Failed to Update Order Status ' . $e->getMessage());

            throw new Exception('Order Status Update Failed ' . $e->getMessage());
        }
    }

    /**
     * Show Status of the Orders
     * @return array|Collection
     */
    public function getAllUserOrders(string $status, User $user)
    {
        try {
            $query = Order::query();

            if ($user->role === User::RIDER) {
                $query->where('riderId', $user->id);
            } elseif ($user->role === User::CUSTOMER) {
                $query->where('customerId', $user->id);
            }

            if ($status !== 'ALL') {
                $query->where('status', $status);
            }

            return $query->with(['rider', 'customer'])->get();
        } catch (Exception $e) {

            Log::error('Failed to fetch All Orders status ' . $e->getMessage());

            throw new Exception('Failed to fetch Status of All Orders: ' . $e->getMessage());
        }
    }

    /**
     * Get Order Details with Rider and Customer
     * @return array|Builder|Collection|Model
     */
    public function getOrderById($orderId)
    {
        try {
            return Order::with(['rider', 'customer'])->findOrFail($orderId);
        } catch (Exception $e) {

            Log::error('Failed to get Order Detail ' . $e->getMessage());

            throw new Exception('Order Detail failed to Load: ' . $e->getMessage());
        }
    }

    /**
     * Edit Description of Pending Order
     * @return array|Order|Collection|Model
     */
    public function editPendingOrder($orderId, array $data, User $user)
    {
        try {
            DB::beginTransaction();

            if ($user->role === User::RIDER) {
                throw new Exception('Only Customer can Edit Order Description');
            }

            $order = Order::findOrFail($orderId);

            if ($order->status !== OrderStatus::PENDING) {
                throw new Exception('Only Pending Order are Editable');
            }

            $order->update($data);

            DB::commit();

            return $order;
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Failed Editing Order ' . $e->getMessage());

            throw new Exception('Editinig Order Failed: ' . $e->getMessage());
        }
    }

    /**
     * Submit Feedback Upon Order Completion
     * @return Model|Order
     */
    public function submitFeedback(array $data)
    {
        try {
            DB::beginTransaction();
            
            $order = Order::where('id', $data['orderId'])->where('customerId', auth()->user()->id)->firstOrFail();

            if ($order->status !== OrderStatus::DELIVERED) {
                throw new Exception('Feedback allowed Only after Order is Delivered');
            }

            $order->update([
                'feedback' => $data['feedback'],
                'status' => OrderStatus::COMPLETED
            ]);

            $firestore = app(Firestore::class);

            $firestore->database()->collection('orders')->document((string)$order->id)->update([
                ['path' => 'riderName', 'value' => $order->rider?->name],
                ['path' => 'customerName', 'value' => $order->customer?->name],
                ['path' => 'status', 'value' => $order->status->value],
                ['path' => 'updatedAt', 'value' => now()->toDateTimeString()],
            ]);

            DB::commit();

            return $order;
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Feedback Submission Failed: ' . $e->getMessage());

            throw new Exception('Failed to Submit Feedback: ' . $e->getMessage());
        }
    }

    /**
     * Sync Order Data to Firestore
     * @return Model|Order
     */
    public function syncFromFirestore(array $data)
    {
        try {
            DB::beginTransaction();

            $order = Order::updateOrCreate(
                ['id' => $data['id']],
                [
                    'status' => $data['status'],
                    'customerId' => $data['customerId'],
                    'riderId' => $data['riderId'],
                    'pickUpLocation' => $data['pickUpLocation'] ?? null,
                    'dropOffLocation' => $data['dropOffLocation'] ?? null,
                    'updatedAt' => $data['updatedAt']
                ]
            );

            $firestore = Firebase::firestore();
            $ordersCollection = $firestore->database()->collection('orders');

            $ordersCollection->document((string)$order->id)->set([
                'id' => $order->id,
                'status' => $order->status->value,
                'customerId' => $order->customerId,
                'riderId' => $order->riderId,
                'pickUpLocation' => $order->pickUpLocation,
                'dropOffLocation' => $order->dropOffLocation,
                'updatedAt' => $order->updatedAt,
            ]);

            DB::commit();

            return $order;
            
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Failed to Sync Order: ' . $e->getMessage());

            throw new Exception('Order Failed to Sync: ' . $e->getMessage());
        }
    }
}
