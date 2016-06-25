<?php

namespace CodeDelivery\Http\Controllers;


use CodeDelivery\Events\OrderItemsWereSavedEvent;
use CodeDelivery\Http\Requests;
use CodeDelivery\Models\Order;
use CodeDelivery\Models\OrderItem;
use CodeDelivery\Models\Product;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use Event;
use Illuminate\Http\Request;
use Session;

class OrderController extends Controller
{
    public function index(OrderRepository $orderRepository)
    {
        $orderCollection = $orderRepository->findWhere(['client_id' => \Auth::user()->id]);
        $statusOptions = $orderRepository->getOrderStatusOptions();
        return view('customer.order.index', compact('orderCollection', 'statusOptions'));
    }

    public function create(OrderRepository $orderRepository)
    {
        $id = Session::get('order_id', 0);
        if ($id > 0) {
            $order = $orderRepository->findOrFail($id);
            $orderItems = $order->items;
            Session::reflash();
        } else {
            $order = new Order();
            $order->id = 0;
            $orderItems = [];
        }

        $foundItems = [];
        return view('customer.order.create', compact('order', 'orderItems', 'foundItems'));
    }

    public function search(Request $request, ProductRepository $product, OrderRepository $orderRepository)
    {
        if ($request->input('order_id') === '0') {
            $order = new Order();
            $order->id = 0;
        } else {
            $order = $orderRepository->findOrFail($request->input('order_id'));
        }
        $orderItems = $order->items;
        $foundItems = $product->search($request->input('product'));

        return view('customer.order.create', compact('order', 'orderItems', 'foundItems'));
    }

    public function addItems(Request $request, OrderRepository $orderRepository, Product $productModel)
    {
        $orderItems = [];
        if ($request->has('item')) {
            if ($request->input('order_id') === '0') {
                $order = new Order();
                $order->client()->associate(\Auth::user());
                $order->save();
            } else {
                $order = $orderRepository->findOrFail($request->input('order_id'));
            }

            $products = $productModel->whereIn('id', $request->input('item'))->get();

            foreach ($products as $product) {
                $orderItem = new OrderItem();
                $orderItem->quantity = 1;
                $orderItem->product()->associate($product);
                $order->items()->save($orderItem);
            }

            Event::fire(new OrderItemsWereSavedEvent($order));
            $orderItems = $order->items;
        }

        Session::flash('order_id', $order->id);
        return redirect()->route('customerOrderNew');
    }
}
