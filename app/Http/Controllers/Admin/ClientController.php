<?php

namespace CodeDelivery\Http\Controllers\Admin;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\Admin\ClientCreateRequest;
use CodeDelivery\Http\Requests\Admin\ClientRequest;
use CodeDelivery\Http\Requests\Admin\ClientUpdateRequest;
use CodeDelivery\Models\Client;
use CodeDelivery\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class ClientController extends Controller
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index()
    {
        $clientCollection = $this->client->all();
        return view('admin.client.index', compact('clientCollection'));
    }

    public function add()
    {
        return view('admin.client.create');
    }

    public function create(ClientCreateRequest $request, User $user)
    {
        $arrRrequest = collect($request->except(['password_confirmation']))
            ->merge(['role' => 'client']);

        $this->client->fill($arrRrequest->all());
        $user->fill($arrRrequest->all())->save();
        $user->client()->save($this->client);

        Session::flash('success', trans('crud.success.saved'));

        return redirect()->route('clientList');
    }

    public function edit($id)
    {
        try {
            $client = $this->client->findOrFail($id);
            return view('admin.client.update', compact('client'));
        } catch (ModelNotFoundException $e) {
            echo trans('crud.record_not_found', ['action' => 'edited']);
        }
    }

    public function update(ClientUpdateRequest $request, $id)
    {
        $except = collect(['password_confirmation']);
        if ($request->has('password') === false) {
            $except->push('password');
        }
        $arrRequest = $request->except($except->all());

        try {
            $client = $this->client->findOrFail($id)->fill($arrRequest);
            $user = $client->user->fill($arrRequest);

            $client->save();
            $user->save();

            Session::flash('success', trans('crud.success.saved'));

            return redirect()->route('clientList');
        } catch (ModelNotFoundException $e) {
            echo 'Registro não localizado para ser editado';
        }
    }

    public function delete($id)
    {
        try {
            $this->client->findOrFail($id)->delete();
            Session::flash('success', trans('crud.success.deleted'));

        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'deleted']));
        }

        return redirect()->route('clientList');
    }
}
