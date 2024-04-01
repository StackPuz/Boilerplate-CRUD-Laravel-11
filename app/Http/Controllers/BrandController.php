<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Util;
use App\Models\Brand;

class BrandController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'Brand.id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = Brand::query()
            ->select('Brand.id', 'Brand.name')
            ->orderBy($sort, $sortDirection);
        if (Util::IsInvalidSearch($query->getQuery()->columns, $column)) {
            abort(403);
        }
        if (request()->input('sw')) {
            $search = request()->input('sw');
            $operator = Util::getOperator(request()->input('so'));
            if ($operator == 'like') {
                $search = '%'.$search.'%';
            }
            $query->where($column, $operator, $search);
        }
        $brands = $query->paginate($size);
        return view('brands.index', ['brands' => $brands]);
    }

    public function create()
    {
        return view('brands.create', ['ref' => Util::getRef('/brands')]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'name' => 'unique:Brand,name|required|max:50'
        ]);
        Brand::create([
            'name' => request()->input('name')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function show($id)
    {
        $brand = Brand::query()
            ->select('Brand.id', 'Brand.name')
            ->where('Brand.id', $id)
            ->first();
        $brandProducts = DB::table('Brand')
            ->join('Product', 'Brand.id', 'Product.brand_id')
            ->select('Product.name', 'Product.price')
            ->where('Brand.id', $id)
            ->get();
        return view('brands.show', ['brand' => $brand, 'ref' => Util::getRef('/brands'), 'brandProducts' => $brandProducts]);
    }

    public function edit($id)
    {
        $brand = Brand::query()
            ->select('Brand.id', 'Brand.name')
            ->where('Brand.id', $id)
            ->first();
        $brandProducts = DB::table('Brand')
            ->join('Product', 'Brand.id', 'Product.brand_id')
            ->select('Product.name', 'Product.price', 'Product.id')
            ->where('Brand.id', $id)
            ->get();
        return view('brands.edit', ['brand' => $brand, 'ref' => Util::getRef('/brands'), 'brandProducts' => $brandProducts]);
    }

    public function update($id)
    {
        Util::setRef();
        $this->validate(request(), [
            'name' => 'required|max:50'
        ]);
        Brand::find($id)->update([
            'name' => request()->input('name')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($id)
    {
        Brand::find($id)->delete();
        return back();
    }
}