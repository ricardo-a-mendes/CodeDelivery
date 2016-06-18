<?php

namespace CodeDelivery\Http\Controllers\Admin;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\Admin\CategoryRequest;
use CodeDelivery\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class CategoryController extends Controller
{

    private $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categoryCollection = $this->category->paginate(10);
        return view('admin.category.index', compact('categoryCollection'));
    }

    public function add()
    {
        $category = $this->category;
        return view('admin.category.create', compact('category'));
    }

    public function create(CategoryRequest $request)
    {
        $this->category->fill($request->all())->save();
        Session::flash('success', trans('crud.success.saved'));
        return redirect()->route('categoryList');
    }

    public function edit($id)
    {
        try {
            $category = $this->category->findOrFail($id);
            return view('admin.category.update', compact('category'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'edited']));
            return redirect()->route('categoryList');
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $this->category->findOrFail($id)->fill($request->all())->save();
            Session::flash('success', trans('crud.success.saved'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'updated']));
        }

        return redirect()->route('categoryList');
    }

    public function delete($id)
    {
        try {
            $this->category->findOrFail($id)->delete();

            Session::flash('success', trans('crud.success.deleted'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'deleted']));
        }

        return redirect()->route('categoryList');
    }
}
