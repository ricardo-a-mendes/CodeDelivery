<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Models\Order;
use CodeDelivery\Models\OrderItems;
use CodeDelivery\Models\Product;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;

class OrderController extends Controller
{
    public function index()
    {
        $orderCollection = [];
        return view('customer.order.index', compact('orderCollection'));
    }

    public function create()
    {
        $order = new Order();
        $orderItems = [];
        $foundItems = [];
        return view('customer.order.create', compact('order', 'orderItems', 'foundItems'));
    }
    
    public function search(Request $request, ProductRepository $product, OrderRepository $orderRepository)
    {
        $order = new Order();
        if ($request->input('order_id') !== '0')
        {
            $order = $orderRepository->findOrFail($request->input('order_id'));
        }
        $orderItems = $order->items;
        $foundItems = $product->search($request->input('product'));
        
        return view('customer.order.create', compact('order', 'orderItems', 'foundItems'));
    }

    public function addItems(Request $request, OrderRepository $orderRepository, Product $productModel)
    {
        $order = new Order();
        if ($request->input('order_id') !== '0')
        {
            $order = $orderRepository->findOrFail($request->input('order_id'));
        }

        if ($request->has('item'))
        {
            $products = $productModel->whereIn('id', $request->input('item'))->get();

            foreach ($products as $product)
            {
                $orderItem = new OrderItems();
                
            }
        }

        $orderItems = $order->items;
        $foundItems = [];
        return view('customer.order.create', compact('order', 'orderItems', 'foundItems'));
    }
}
