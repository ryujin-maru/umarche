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
                    <form method="post" action="{{route('owner.product.store')}}" >
                        @csrf
                            <div class="-m-2">
                                <div class="p-2 w-1/2 mx-auto">
                                    <div class="relative">
                                        <select name="category">
                                            @foreach ($categories as $category)
                                                <optgroup label="{{$category->name}}">
                                                    @foreach ($category->secondary as $secondary)
                                                        <option value="{{$secondary->id}}">
                                                            {{$secondary->name}}
                                                        </option>
                                                    @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="p-2 w-full flex justify-around mt-4">
                                <button type="button" onclick="location.href='{{ route('owner.product.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
                            </div>          
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>