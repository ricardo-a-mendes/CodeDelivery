<?php

namespace CodeDelivery\Http\Controllers\Admin;

use CodeDelivery\Models\Client;
use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;

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
        return view('client.index', compact('clientCollection'));
    }

    public function add()
    {
        return view('client.create');
    }

    public function create($request)
    {
        $this->client->fill($request->all())->save();
        return redirect()->route('clientList');
    }

    public function edit($id)
    {
        try {
            $client = $this->client->findOrFail($id);
            return view('client.update', compact('client'));
        } catch (ModelNotFoundException $e) {
            echo 'Registro Não Localizado';
        }
    }

    public function update($request, $id)
    {
        try {
            $this->client->findOrFail($id)->fill($request->all())->save();
            return redirect()->route('clientList');
        } catch (ModelNotFoundException $e) {
            echo 'Registro não localizado para ser editado';
        }
    }

    public function delete($id)
    {
        try {
            $this->client->findOrFail($id)->delete();
            return redirect()->route('clientList');
        } catch (ModelNotFoundException $e) {
            echo 'Registro não localizado para ser deletado';
        }
    }
}
