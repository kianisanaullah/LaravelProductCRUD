<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::all();
        return view('product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        $brands=Brand::all();
        $sizes=Size::all();
        return view('product.create',compact('categories','brands','sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateProduct($request);
        $data=Request::except('_token','photo');
        if($request->hasFile('photo')){
            $file=$request->file('photo');
            $name=time().$file->getClientOriginalName();
            $file->move('images',$name);
            $data['photo']=$name;
        }
        Product::created($data);
        return redirect('product')->with('message','Product Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories=Category::all();
        $brands=Brand::all();
        $sizes=Size::all();
        return view('product.edit',compact('product','categories','brands','sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->validateProduct($request,true);
        $data=Request::except('_token','_method','photo');
        if($request->hasFile('photo')){
            $file=$request->file('photo');
            $name=time().$file->getClientOriginalName();
            $file->move('images',$name);
            $previousPhoto=$product->photo;
            if ($previousPhoto) {
                $previousPhotoPath = public_path( $previousPhoto);
                if (file_exists($previousPhotoPath)) {
                    unlink($previousPhotoPath);
                }
            }
            $data['photo']=$name;
        }
        $product->update($data);
        return redirect('product')->with('message','Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('product')->with('message','Product Deleted Successfully');
    }

    private function validateProduct(Request $request, $isUpdate = false)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'size_id' => 'required|numeric',
            'cost' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'workshop_price' => 'required|numeric',
            'century_price' => 'required|numeric',
            'agent_commission' => 'required|numeric',
            'partner_commission' => 'required|numeric'
        ];
        if (!$isUpdate) {
            $rules['photo'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
        } else {
            $rules['photo'] = 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048';
        }

        return $request->validate($rules);
    }
}
