<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use App\Models\Shop;
use App\Models\Stock;
use App\Models\PrimaryCategory;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth:owners');

        $this->middleware(function($request,$next) {
            $id = $request->route('product');
            if(!is_null($id)) {
                $owner_id = Product::findOrFail($id)->shop->owner->id;

                if(Auth::id() !== intval($owner_id)) {
                    abort(404);
                }
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = Owner::findOrFail(Auth::id())->shop->product;

        $ownerInfo = Owner::with('shop.product.imageFirst')->where('id',Auth::id())->get();
        // foreach($ownerInfo as $owner) {
        //     foreach($owner->shop->product as $product) {

        //     }
        // }
        return view('owner.products.index',compact('ownerInfo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = Shop::where('owner_id',Auth::id())->select('id','name')->get();

        $images = Image::where('owner_id',Auth::id())->select('id','title','filename')->orderBy('updated_at','DESC')->get();

        $categories = PrimaryCategory::with('secondary')->with('secondary')->get();

        return view('owner.products.create',compact('shops','images','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            DB::transaction(function() use($request) {
                $product = Product::create([
                    'name' => $request->name,
                    'information' => $request->information,
                    'price' => $request->price,
                    'sort_order' => $request->sort_order,
                    'shop_id' => $request->shop_id,
                    'secondary_category_id' => $request->category,
                    'image1' => $request->image1,
                    'image2' => $request->image2,
                    'image3' => $request->image3,
                    'image4' => $request->image4,
                    'is_selling' => $request->is_selling,
                ]);

                Stock::create([
                    'product_id' => $product->id,
                    'type' => 1,
                    'quantity' => $request->quantity
                ]);
            });

        }catch(Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return to_route('owner.product.index')->with(['message'=>'商品登録をしました。','status'=>'info']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id',$product->id)->sum('quantity');

        $shops = Shop::where('owner_id',Auth::id())->select('id','name')->get();

        $images = Image::where('owner_id',Auth::id())->select('id','title','filename')->orderBy('updated_at','DESC')->get();

        $categories = PrimaryCategory::with('secondary')->with('secondary')->get();

        return view('owner.products.edit',compact('product','shops','images','categories','quantity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $request->validate([
            'current_quantity' => 'required|integer'
        ]);

        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id',$product->id)->sum('quantity');

        if($request->current_quantity !== $quantity) {
            return to_route('owner.product.edit',['product'=>$id])->with(['message'=>'在庫数が変更されています。','status'=>'alert']);
        }else{
            try {
                DB::transaction(function() use($request,$product) {
                    $product->name = $request->name;
                    $product->information = $request->information;
                    $product->price = $request->price;
                    $product->sort_order = $request->sort_order;
                    $product->shop_id = $request->shop_id;
                    $product->secondary_category_id = $request->category;
                    $product->image1 = $request->image1;
                    $product->image2 = $request->image2;
                    $product->image3 = $request->image3;
                    $product->image4 = $request->image4;
                    $product->is_selling = $request->is_selling;
                    $product->save();

                    if($request->type === \Constant::PRODUCT_LIST['add']) {
                        $newQuantity = $request->quantity;
                    }elseif($request->type === \Constant::PRODUCT_LIST['reduce']) {
                        $newQuantity = $request->quantity * -1;
                    }

                    Stock::create([
                        'product_id' => $product->id,
                        'type' => $request->type,
                        'quantity' => $newQuantity
                    ]);
                });
            }catch(Throwable $e) {
                Log::error($e);
                throw $e;
            }

            return to_route('owner.product.index')->with(['message'=>'商品情報を更新をしました。','status'=>'info']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return to_route('owner.product.index')->with(['message'=>'商品を削除しました。','status'=>'alert']);
    }
}
