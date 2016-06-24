<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = \DB::table('order_items')
            ->selectRaw('sum(order_items.quantity*products.price) as total')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('order_id', '=', 1)
            ->first();
        dd($q->total);
        return view('home');
    }
}
