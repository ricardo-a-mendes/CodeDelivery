<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Models\Order;
use CodeDelivery\Models\OrderItem;
use CodeDelivery\Repositories\OrderRepository;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientCheckoutController extends Controller
{
    /**
     * @var Order
     */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index(OrderRepository $orderRepository)
    {
        $clientId = Authorizer::getResourceOwnerId();
        $orderCollection = $orderRepository->with(['items'])->scopeQuery(function ($query) use ($clientId){
            return $query->where('client_id', '=', $clientId);
        })->paginate(10);

        return $orderCollection;
    }

    public function store(Request $request)
    {
        $clientId = Authorizer::getResourceOwnerId();
        $dataOrder = $request->all();

        $dataOrder['client_id'] = $clientId;
        $this->order->fill($dataOrder)->save();
        if ($request->has('items'))
        {
            foreach ($request->items as $item) {
                if (key_exists('product_id', $item) && key_exists('quantity', $item))
                {
                    $orderItem = new OrderItem();
                    $orderItem->fill($item);
                    $this->order->orderItems()->save($orderItem);
                }
            }
        }

        //Just to show the items into Order
        $this->order->orderItems;

        return $this->order;
    }

    public function show($id)
    {
        $clientId = Authorizer::getResourceOwnerId();
        $order = $this->order->with(['client', 'orderItems'])->where('client_id', '=', $clientId)->find($id);
        if (is_null($order))
        {
            return ['Sorry, this Order does not belongs to you!'];
        }

        $order->orderItems->each(function ($item){
            $item->product;
        });
        return $order;
    }
}
