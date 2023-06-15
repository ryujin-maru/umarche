<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;

class ShopController extends Controller
{
    //
    public function __construct()
    {
        // ログインしているかの確認
        $this->middleware('auth:owners');

        $this->middleware(function($request,$next) {
            $owner_route = $request->route('shop');
            if(!is_null($owner_route)) {
                if(Auth::id() !== intval($owner_route)) {
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        $shops = Shop::where('owner_id',Auth::id())->get();

        return view('owner.shops.index',compact('shops'));
    }

    public function edit($id)
    {

    }

    public function update(Request $request,$id)
    {

    }
}
