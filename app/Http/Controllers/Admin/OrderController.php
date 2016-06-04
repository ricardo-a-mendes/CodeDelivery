<?php

namespace CodeDelivery\Http\Controllers\Admin;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Session;

class OrderController extends Controller
{
    private $order;
    private $orderStatus = [0 => 'Canceled', 1 => 'In Progress', 2 => 'Shipping', 3 => 'Finalized'];

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $orderCollection = $this->order->all();
        $orderStatus = $this->orderStatus;
        return view('admin.order.index', compact('orderCollection', 'orderStatus'));
    }

    public function add()
    {
        return view('order.create');
    }

    public function create(Request $request)
    {
        $this->order->fill($request->all())->save();
        Session::flash('success', trans('crud.success.saved'));
        return redirect()->route('orderList');
    }

    public function edit($id)
    {
        try {
            $order = $this->order->findOrFail($id);
            return view('order.update', compact('order'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'edited']));
            return redirect()->route('orderList');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->order->findOrFail($id)->fill($request->all())->save();
            Session::flash('success', trans('crud.success.saved'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'updated']));
        }

        return redirect()->route('orderList');
    }

    public function delete($id)
    {
        try {
            $this->order->findOrFail($id)->delete();

            Session::flash('success', trans('crud.success.deleted'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'deleted']));
        }

        return redirect()->route('orderList');
    }
}
