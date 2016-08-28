<?php

namespace CodeDelivery\Http\Controllers\Admin;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests\Admin\CategoryRequest;
use CodeDelivery\Models\Category;
use CodeDelivery\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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

    public function create()
    {
        $category = new Category();
        return view('admin.category.create', compact('category'));
    }

    public function store(CategoryRequest $request, Category $category)
    {
        $category->fill($request->all())->save();
        Session::flash('success', trans('crud.success.saved'));
        return redirect()->route('admin.category.index');
    }

    public function edit($id)
    {
        try {
            $category = $this->category->findOrFail($id);
            return view('admin.category.update', compact('category'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'edited']));
            return redirect()->route('admin.category.index');
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

        return redirect()->route('admin.category.index');
    }

    public function delete(Request $request)
    {
        try {
            $category = $this->category->findOrFail($request->id);
            if($category->products->count() === 0)
            {
                $category->delete();
                Session::flash('success', trans('crud.success.deleted'));
            }
            else
            {
                Session::flash('error', trans_choice('crud.category_has_products', $category->products->count(), ['qtdProducts' => $category->products->count()]));
            }

        } catch (ModelNotFoundException $e) {
            Session::flash('error', trans('crud.record_not_found', ['action' => 'deleted']));
        }

        return redirect()->route('admin.category.index');
    }
}
