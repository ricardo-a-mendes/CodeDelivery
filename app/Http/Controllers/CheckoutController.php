<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Models\Order;
use CodeDelivery\Models\User;
use CodeDelivery\Repositories\ProductRepository;

class CheckoutController extends Controller
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var User
     */
    private $user;
    /**
     * @var Product
     * @property ProductRepository $product
     */
    private $product;

    public function __construct(Order $order, User $user, ProductRepository $product)
    {
        $this->order = $order;
        $this->user = $user;
        $this->product = $product;
    }

    public function create()
    {
        $products = $this->product->lists('name', 'id');
        $products1= $this->product->fof(1);
        return view('customer.order.create', compact('products'));
    }
}
