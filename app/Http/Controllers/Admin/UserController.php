<?php

namespace CodeDelivery\Http\Controllers\Admin;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\Admin\UserCreateRequest;
use CodeDelivery\Http\Requests\Admin\UserUpdateRequest;
use CodeDelivery\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class UserController extends Controller
{
    private $user;
    private $roles = ['admin' => 'Admin', 'client' => 'Client', 'deliveryman' => 'Delivery Man'];

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $userCollection = $this->user->paginate(10);
        $roles = $this->roles;
        return view('admin.user.index', compact('userCollection', 'roles'));
    }

    public function add()
    {
        $user = $this->user;
        $roles = $this->roles;
        return view('admin.user.create', compact('roles', 'user'));
    }

    public function create(UserCreateRequest $request)
    {
        $this->user->fill($request->all())->save();
        Session::flash('success', trans('crud.success.saved'));
        return redirect()->route('userList');
    }

    public function edit($id)
    {
        try {
            $roles = $this->roles;
            $user = $this->user->findOrFail($id);
            return view('admin.user.update', compact('user','roles'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'edited']));
            return redirect()->route('userList');
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            $this->user->findOrFail($id)->fill($request->all())->save();
            Session::flash('success', trans('crud.success.saved'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'updated']));
        }

        return redirect()->route('userList');
    }

    public function delete($id)
    {
        try {
            $user = $this->user->findOrFail($id);

            if ($user->client->orders->count() === 0)
            {
                $user->delete();
                Session::flash('success', trans('crud.success.deleted'));
            }
            else
            {
                Session::flash('error', trans_choice('crud.client_has_orders', $user->client->orders->count(), ['qtdOrders' => $user->client->orders->count()]));   
            }
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'deleted']));
        }

        return redirect()->route('userList');
    }
}
