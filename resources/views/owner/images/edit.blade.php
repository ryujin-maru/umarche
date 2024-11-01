<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-400">{{$error}}</p>
                    @endforeach
                    <form method="post" action="{{route('owner.images.update',['image' => $image->id])}}" >
                        @method('PUT')
                        @csrf
                            <div class="-m-2">
                                
                                <div class="p-2 w-1/2 mx-auto">
                                    <div class="relative">
                                        <label for="title"
                                            class="leading-7 text-sm text-gray-600">画像タイトル</label>
                                        <input type="text" id="image" name="title" value="{{$image->title}}"
                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-1/2 mx-auto">
                                    <div class="w-32">
                                        <x-thumbnail :filename="$image->filename" type='products'/>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 w-full flex justify-around mt-4">
                                <button type="button" onclick="location.href='{{ route('owner.images.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                            </div>          
                    </form>
                    <form method="POST" id="delete_{{$image->id}}" action="{{route('owner.images.destroy',['image'=>$image->id])}}">
                        @csrf
                        @method('DELETE')
                        <div class="px-4 py-2">
                            <div class="p-2 w-full flex justify-around mt-32">
                                <a href="#" data-id="{{$image->id}}" onclick="deletePost(this)"
                            class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</a>
                            </div>
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
<script>
    function deletePost(e) {
        'use strict';
        if(confirm('本当に削除してもいいですか？')) {
            document.getElementById('delete_'+e.dataset.id).submit();
        }
    }
</script>
</x-app-layout>
