<?php

namespace CodeDelivery\Http\Controllers\Admin;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Models\Order;
use CodeDelivery\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class OrderController extends Controller
{
    private $order;
    private $orderStatus = [0 => 'Canceled', 1 => 'In Progress', 2 => 'Shipping', 3 => 'Finalized'];
    private $deliveryMen;

    public function __construct(Order $order, User $user)
    {
        $this->order = $order;

        $deliveryMen = $user->select('id', 'name')
            ->where('role', '=', 'deliveryman')
            ->orderBy('name')
            ->get();
        foreach ($deliveryMen as $deliveryMan)
        {
            $this->deliveryMen[$deliveryMan->id] = $deliveryMan->name;
        }
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
            $orderStatus = $this->orderStatus;
            $deliveryMen = $this->deliveryMen;
            return view('admin.order.update', compact('order', 'orderStatus', 'deliveryMen'));
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
