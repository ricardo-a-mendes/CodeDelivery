<?php

namespace CodeDelivery\Http\Controllers\Customer;

use CodeDelivery\Events\OrderItemsWereSavedEvent;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests\CheckoutRequest;
use CodeDelivery\Models\Order;
use CodeDelivery\Models\Product;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\OrderItemRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderService;
use Event;
use Illuminate\Http\Request;
use Session;

class OrderController extends Controller
{
    public function index(OrderRepository $orderRepository)
    {
        $orderCollection = $orderRepository->getByUserID(\Auth::user()->id);
        $statusOptions = $orderRepository->getOrderStatusOptions();
        return view('customer.order.index', compact('orderCollection', 'statusOptions'));
    }

    public function create(OrderRepository $orderRepository)
    {
        $id = Session::get('order_id', 0);
        if ($id > 0) {
            $order = $orderRepository->findOrFail($id);
            $orderItems = $order->orderItems;
            Session::reflash();
        } else {
            $order = new Order();
            $order->id = 0;
            $orderItems = [];
        }

        $foundItems = [];
        $isSearch = false;
        return view('customer.order.create', compact('order', 'orderItems', 'foundItems', 'isSearch'));
    }

    public function edit($id)
    {
        Session::flash('order_id', $id);
        return redirect()->route('customer.order.create');
    }

    public function store(CheckoutRequest $request, OrderItemRepository $orderItemRepository)
    {
        if ($request->has('update'))
            $this->updateItems($request, $orderItemRepository);

        if ($request->has('checkout'))
            $this->checkout($request, $orderItemRepository);

        return redirect()->route('customer.order.create');
    }

    public function updateItems(Request $request, OrderItemRepository $orderItemRepository)
    {
        $orderID = $request->input('order_id');

        $changedItems = array_diff_assoc($request->input('quantity'), $request->input('quantity_hidden'));
        if (count($changedItems) > 0)
        {
            try {
                $order = $orderItemRepository->getOrder($orderID);
                foreach ($changedItems as $itemID => $newQuantity) {
                    $orderItemRepository->update(['quantity' => $newQuantity], $itemID);
                }
                Event::fire(new OrderItemsWereSavedEvent($order));
                Session::flash('success', trans_choice('crud.success.saved', count($changedItems)));
            } catch (ModelNotFoundException $e) {
                Session::flash('error', trans('crud.record_not_found', ['action' => 'edited']));
            }
        }
        else
        {
            Session::flash('info', trans('crud.info.nothing_to_be_saved'));
        }

        //Session::flash('order_id', $orderID);
        // return redirect()->route('customer.order.create');
    }

    public function checkout(Request $request, OrderItemRepository $orderItemRepository)
    {
        //dd($request->all());
    }

    public function search(Request $request, ProductRepository $product, OrderRepository $orderRepository)
    {
        if ($request->input('order_id') === '0') {
            $order = new Order();
            $order->id = 0;
        } else {
            $order = $orderRepository->findOrFail($request->input('order_id'));
        }
        $orderItems = $order->orderItems;
        $foundItems = $product->search($request->input('product'));
        $isSearch = true;
        return view('customer.order.create', compact('order', 'orderItems', 'foundItems', 'isSearch'));
    }

    public function addItems(Request $request, Product $productModel, ClientRepository $clientRepository, OrderService $orderService)
    {
        if ($request->has('items')) {

            $client = $clientRepository->getByUserID(\Auth::id());
            $order = $orderService->getOrNew($request->input('order_id'), $client->id);
            Session::flash('order_id', $order->id);

            $products = $productModel->whereIn('id', $request->input('items'))->get();

            foreach ($products as $product) {
                $orderService->createOrUpdateItem($order, $product);
            }
            Event::fire(new OrderItemsWereSavedEvent($order));
        }
        else
        {
            Session::flash('order_id', 0);
        }

        return redirect()->route('customer.order.create');
    }

    public function removeItem(OrderItemRepository $orderItemRepository, $id)
    {
        try {
            $orderItem = $orderItemRepository->find($id);
            $order = $orderItem->order;

            $orderItemRepository->delete($id);

            Event::fire(new OrderItemsWereSavedEvent($order));
            Session::flash('success', trans('crud.success.deleted'));
            Session::flash('order_id', $order->id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'edited']));
        }

        return redirect()->route('customer.order.create');
    }
}
