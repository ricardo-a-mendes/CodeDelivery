<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Models\Order;
use CodeDelivery\Models\User;
use CodeDelivery\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $products = [];
        try {
            //$products = $this->product->lists('name', 'id');
            $products = $this->product->findOrFail(1000000);
        } catch (ModelNotFoundException $e) {
            echo $e->getTraceAsString();
        }
        
        return view('customer.order.create', compact('products'));
    }
}
