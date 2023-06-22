<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function __construct() {
        $this->middleware('auth:owners');

        $this->middleware(function($request,$next) {
            $id = $request->route('image');
            if(!is_null($id)) {
                $imagesOwnerId = Image::findOrFail($id)->owner->id;
                if(Auth::id() !== intval($imagesOwnerId)) {
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
        $images = Image::where('owner_id',Auth::id())
        ->orderBy('updated_at','DESc')
        ->paginate(20);

        return view('owner.images.index',compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadImageRequest $request)
    {
        $imageFiles = $request->file('files');
        if(!is_null($imageFiles)) {
            foreach($imageFiles as $imageFile) {
                $fileNameToStore = ImageService::upload($imageFile,'products');
                $image = new Image;
                $image->owner_id = Auth::id();
                $image->filename = $fileNameToStore;
                $image->save();
            }
        }
        return to_route('owner.images.index')
        ->with(['message'=>'画像登録しました。','status'=>'info']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $image = Image::findOrFail($id);
        return view('owner.images.edit',compact('image'));
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
        $request->validate([
            'title' => 'string|max:50',
        ]);

        $image = Image::findOrFail($id);
        $image->title = $request->title;
        $image->save();

        return to_route('owner.images.index')->with(['message'=>'画像登録しました。','status'=>'info']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $filePath = 'public/products/'.$image->filename;
        if(Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        Image::findOrFail($id)->delete();

        return to_route('owner.images.index')->with(['message'=>'画像を削除しました。','status'=>'alert']);
    }
}
