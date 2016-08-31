<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Events\OrderItemsWereSavedEvent;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Models\Order;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderService;
use Event;
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
        $orderCollection = $orderRepository->with(['orderItems'])->scopeQuery(function ($query) use ($clientId){
            return $query->where('client_id', '=', $clientId);
        })->paginate(10);

        return $orderCollection;
    }

    public function store(Request $request, OrderService $orderService, ClientRepository $clientRepository, ProductRepository $productRepository)
    {
        $orderHasValidItems = false;
        if ($request->has('orderItems'))
        {
            $client = $clientRepository->getByUserID(Authorizer::getResourceOwnerId());
            $order = $orderService->getOrNew(0, $client->id);

            foreach ($request->orderItems as $item) {
                if (key_exists('product_id', $item) && key_exists('quantity', $item))
                {
                    $orderHasValidItems = true;
                    $product = $productRepository->find($item['product_id']);
                    $orderService->createOrUpdateItem($order, $product, $item['quantity']);
                }
            }

            if ($orderHasValidItems === true)
            {
                Event::fire(new OrderItemsWereSavedEvent($order));

                //Just to show the items into Order
                $order->orderItems;

                return $order;
            }
        }

        return ['message' => trans('api.items_missed_to_create_order')];
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
