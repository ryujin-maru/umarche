@php
    if($type === 'shops') {
        $path = 'storage/shops/';
    }
    if($type === 'products') {
        $path = 'storage/products/';
    }
@endphp

<div>
    @if(empty($shop->filename))
        <img src="{{asset('images/no_image.jpg')}}">
    @else
        <img src="{{asset($path.$shop->filename)}}">
    @endif
</div>