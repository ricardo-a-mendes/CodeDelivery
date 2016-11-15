<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Events\OrderItemsWereSavedEvent;
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
        return view('client.order.index', compact('orderCollection', 'statusOptions'));
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
        return view('client.order.create', compact('order', 'orderItems', 'foundItems', 'isSearch'));
    }

    public function edit($id)
    {
        Session::flash('order_id', $id);
        return redirect()->route('client.order.create');
    }

    public function store(CheckoutRequest $request, OrderItemRepository $orderItemRepository)
    {
        if ($request->has('update')) {
            $this->updateItems($request, $orderItemRepository);
        }

        if ($request->has('checkout')) {
            $this->checkout($request, $orderItemRepository);
        }

        return redirect()->route('client.order.create');
    }

    public function updateItems(Request $request, OrderItemRepository $orderItemRepository)
    {
        $orderID = $request->input('order_id');
        $changedItems = 0;

        try {
            $order = $orderItemRepository->getOrder($orderID);
            foreach ($request->input('orderItems') as $item) {
                if ($item['quantity'] != $item['quantity_hidden']) {
                    $orderItemRepository->update(['quantity' => $item['quantity']], $item['product_id']);
                    $changedItems++;
                }
            }

            if ($changedItems > 0) {
                Event::fire(new OrderItemsWereSavedEvent($order));
                Session::flash('success', trans_choice('crud.success.saved', count($changedItems)));
            } else {
                Session::flash('info', trans('crud.info.nothing_to_be_saved'));
            }

        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'edited']));
        }

        //Session::flash('order_id', $orderID);
        // return redirect()->route('client.order.create');
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
        return view('client.order.create', compact('order', 'orderItems', 'foundItems', 'isSearch'));
    }

    public function addItems(Request $request,
        Product $productModel,
        ClientRepository $clientRepository,
        OrderService $orderService)
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
        } else {
            Session::flash('order_id', 0);
        }

        return redirect()->route('client.order.create');
    }

    public function destroy(OrderItemRepository $orderItemRepository, $id)
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

        return redirect()->route('client.order.create');
    }
}
