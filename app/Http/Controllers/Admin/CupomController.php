<?php

namespace CodeDelivery\Http\Controllers\Admin;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\Admin\CupomRequest;
use CodeDelivery\Models\Cupom;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class CupomController extends Controller
{
    private $cupom;

    public function __construct(Cupom $cupom)
    {
        $this->cupom = $cupom;
    }

    public function index()
    {
        $cupomCollection = $this->cupom->paginate(10);
        return view('admin.cupom.index', compact('cupomCollection'));
    }

    public function create()
    {
        $cupom = $this->cupom;
        return view('admin.cupom.create', compact('cupom'));
    }

    public function store(CupomRequest $request)
    {
        $this->cupom->fill($request->all())->save();
        Session::flash('success', trans('crud.success.saved'));
        return redirect()->route('admin.cupom.index');
    }

    public function edit($id)
    {
        try {
            $cupom = $this->cupom->findOrFail($id);
            return view('admin.cupom.update', compact('cupom'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'edited']));
            return redirect()->route('admin.cupom.index');
        }
    }

    public function update(CupomRequest $request, $id)
    {
        try {
            $this->cupom->findOrFail($id)->fill($request->all())->save();
            Session::flash('success', trans('crud.success.saved'));
            return redirect()->route('admin.cupom.index');
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'updated']));
            return redirect()->route('admin.cupom.index');
        }
    }

    public function delete($id)
    {
        try {
            $cupom = $this->cupom->findOrFail($id);

            if ($cupom->used === 0)
            {
                $cupom->delete();
                Session::flash('success', trans('crud.success.deleted'));
            }
            else
            {
                Session::flash('error', trans('crud.cupom_was_used'));
            }
            return redirect()->route('admin.cupom.index');
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'deleted']));
        }
        return redirect()->route('admin.cupom.index');
    }
}
