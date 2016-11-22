<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use CodeDelivery\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Services\OrderService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class DeliverymanCheckoutController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $order;
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderRepository $orderRepository, OrderService $orderService)
    {
        $this->order = $orderRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $deliverymanId = Authorizer::getResourceOwnerId();

        $orderCollection = $this->order
            ->skipPresenter(false)
            ->findWhere(['user_deliveryman_id' => $deliverymanId]);

        return $orderCollection;
    }

    public function show($id)
    {
        $deliverymanId = Authorizer::getResourceOwnerId();
        return $this->order
            ->skipPresenter(false)
            ->getByOrderIDAndDeliverymanID($id, $deliverymanId);
    }

    public function updateStatus(Request $request, $id)
    {
        if (!$request->has('status'))
            abort(400, 'Missing Status Information');

        $status = $request->get('status');
        $deliverymanID = Authorizer::getResourceOwnerId();

        try {
            //Check if Order belongs to deliveryman
            $order = $this->order->getByOrderIDAndDeliverymanID($id, $deliverymanID);

            if ($order->count() > 0) {
                $order = $this->orderService->updateStatus($id, $status);
                return $order;
            }

            abort(400, 'Order not found.');
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }
}
