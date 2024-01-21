<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Stripe\Stripe;
use Helper;

use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::getAllProduct();
        // return $products;
        return view('backend.product.index')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand=Brand::get();
        $category=Category::where('is_parent',1)->get();
        // return $category;
        return view('backend.product.create')->with('categories',$category)->with('brands',$brand);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        // $this->validate($request,[
        //     'title'=>'string|required',
        //     'summary'=>'string|required',
        //     'description'=>'string|nullable',
        //     'photo'=>'string|required',
        //     'size'=>'nullable',
        //     'stock'=>"required|numeric",
        //     'cat_id'=>'required|exists:categories,id',
        //     'brand_id'=>'nullable|exists:brands,id',
        //     'child_cat_id'=>'nullable|exists:categories,id',
        //     'is_featured'=>'sometimes|in:1',
        //     'status'=>'required|in:active,inactive',
        //     'condition'=>'required|in:default,new,hot',
        //     'price'=>'required|numeric',
        //     'discount'=>'nullable|numeric'
        // ]);

        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Product::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['is_featured']=$request->input('is_featured',0);
        $size=$request->input('size');
        if($size){
            $data['size']=implode(',',$size);
        }
        else{
            $data['size']='';
        }

        do {
            $product_api_id = strtoupper(Helper::random_str(10));
            $productid_used = Product::where('product_api_id', $product_api_id)->exists();
        } while ($productid_used);

        $data['product_api_id'] = $product_api_id;

        if($data['discount']){
            $total_amount = $data['price'] - ($data['price'] * ($data['discount'] / 100));
            $total_amount = $total_amount . '00';
        } else {
            $total_amount = number_format($data['price'], 2);
        }

        $stripe = new \Stripe\StripeClient(config('app.stripe_secret'));

        $stripe->products->create([
            'id' => $data['product_api_id'],
            'active' => true,
            'name' => $data['title'],  
        ]);

        $stripe->prices->create([
            'product' => $data['product_api_id'],
            'unit_amount' => $total_amount,
            'currency' => 'myr',
        ]);
        // return $size;
        // return $data;
        $status=Product::create($data);
        
        if($status){
            request()->session()->flash('success','Product Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand=Brand::get();
        $product=Product::findOrFail($id);
        $category=Category::where('is_parent',1)->get();
        $items=Product::where('id',$id)->get();
        // return $items;
        return view('backend.product.edit')->with('product',$product)
                    ->with('brands',$brand)
                    ->with('categories',$category)->with('items',$items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product=Product::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'size'=>'nullable',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'brand_id'=>'nullable|exists:brands,id',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric',
        ]);

        $data=$request->all();
        $data['is_featured']=$request->input('is_featured',0);
        $size=$request->input('size');
        if($size){
            $data['size']=implode(',',$size);
        }
        else{
            $data['size']='';
        }

        if($data['price'] != $product->price || $data['discount'] != $product->discount){

            if($data['discount']){
                $total_amount = $data['price'] - ($data['price'] * ($data['discount'] / 100));
                $total_amount = $total_amount . '00';
            } else {
                $total_amount = $data['price'] . '00';
            }

            $stripe = new \Stripe\StripeClient(config('app.stripe_secret'));

            $old_stripe_price = $stripe->prices->all([
                'product' => $product->product_api_id,
                'active' => true,
            ]);
            foreach($old_stripe_price as $price){
                $stripe->prices->update($price->id, ['active' => false]);
            }

            $price = $stripe->prices->create([
                'product' => $product->product_api_id,
                'unit_amount' => $total_amount,
                'currency' => 'myr',
            ]);

            $stripe->products->update(
                $product->product_api_id,
                ['default_price' => $price->id]
              );
        } 

        // return $data;
        $status=$product->fill($data)->save();
        if($status){
            request()->session()->flash('success','Product Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $status=$product->delete();
        
        if($status){
            request()->session()->flash('success','Product successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('product.index');
    }
}
