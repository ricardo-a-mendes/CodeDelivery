<?php

namespace CodeDelivery\Http\Controllers\Admin;

use CodeDelivery\Helpers\FormHelper;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Session;

class OrderController extends Controller
{
    private $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $orderCollection = $this->order->paginate(10);
        $orderStatus = $this->order->getOrderStatusOptions();
        return view('admin.order.index', compact('orderCollection', 'orderStatus'));
    }

    public function create()
    {
        //TODO: Create order and select client
    }

    public function store(Request $request)
    {
        $this->order->fill($request->all())->save();
        Session::flash('success', trans('crud.success.saved'));
        return redirect()->route('admin.order.index');
    }

    public function edit($id, UserRepository $user)
    {
        try {
            $order = $this->order->findOrFail($id);
            $orderStatus = $this->order->getOrderStatusOptions();

            $deliveryMen = FormHelper::bindDropDown($user->getDeliveryMen());
            return view('admin.order.update', compact('order', 'orderStatus', 'deliveryMen'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'edited']));
            return redirect()->route('admin.order.index');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $itemsToSave = $request->all();

            //If not selected
            if ($request->input('user_deliveryman_id') === '0')
            {
               $itemsToSave = $request->except('user_deliveryman_id');
            }

            $this->order->findOrFail($id)->fill($itemsToSave)->save();
            Session::flash('success', trans('crud.success.saved'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'updated']));
        }

        return redirect()->route('admin.order.index');
    }
}
