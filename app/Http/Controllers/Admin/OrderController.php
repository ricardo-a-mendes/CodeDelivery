<?php

namespace CodeDelivery\Http\Controllers\Admin;

use CodeDelivery\Helpers\FormHelper;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Models\Order;
use CodeDelivery\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Session;

class OrderController extends Controller
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $orderCollection = $this->order->paginate(10);
        $orderStatus = $this->order->getOrderStatusOptions();
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

    public function edit($id, User $user)
    {
        try {
            $order = $this->order->findOrFail($id);
            $orderStatus = $this->order->getOrderStatusOptions();

            $deliveryMen = FormHelper::bindDropDown($user->getDeliveryMen());
            return view('admin.order.update', compact('order', 'orderStatus', 'deliveryMen'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'edited']));
            return redirect()->route('orderList');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $itemsToSave = $request->all();

            //If not selected
            if ($request->input('user_deleveryman_id') === '0')
            {
               $itemsToSave = $request->except('user_deleveryman_id');
            }
            
            $this->order->findOrFail($id)->fill($itemsToSave)->save();
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
