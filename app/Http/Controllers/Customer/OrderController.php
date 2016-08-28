<?php

namespace CodeDelivery\Http\Controllers\Customer;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Models\Order;
use CodeDelivery\Models\OrderItem;
use CodeDelivery\Models\Product;
use CodeDelivery\Repositories\OrderItemRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Session;
use Event;
use CodeDelivery\Events\OrderItemsWereSavedEvent;

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

    public function edit($id)
    {
        Session::flash('order_id', $id);
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

        Session::flash('order_id', $orderID);
        return redirect()->route('customer.order.create');
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

    public function itemsAdd(Request $request, OrderRepository $orderRepository, Product $productModel)
    {
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
        }

        Session::flash('order_id', $order->id);
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
