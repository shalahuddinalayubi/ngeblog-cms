@extends('template::app')

@section('body')

@include('template::navbar')

<div class="container mx-auto pb-5">
    <div class="flex flex-col lg:flex-row justify-center">
        <form action="{{ route('posts.store') }}" method="POST" class="w-full lg:w-1/2 px-3 py-3">
            @csrf

            <div class="flex flex-col py-2">
                <label for="title">Judul</label>
                <input type="text" name="title" id="title" class="shadow focus:ring-2 focus:ring-blue-500 appearance-none text-sm border border-gray-300 @error('title') border-red-500 @enderror rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('title') }}">
                @error('title')
                    <div class="text-xs text-red-500">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <the-post-editor has-error="{{ $errors->has('content') }}" name="content" value="{{ old('content') }}">
            </the-post-editor>
            @error('content')
                <div class="text-xs text-red-500">
                    {{ $message }}
                </div>
            @enderror

            <div class="flex flex-col py-2">
                <label for="content">Tag</label>
                <tag :old-value="{{ json_encode(old('tags')) }}" has-error="{{ $errors->has('tags') }}"></tag>
                @error('tags')
                    <div class="text-xs text-red-500">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 mt-2 px-4 rounded">Tambah</button>
        </form>
    </div>
</div>
@endsection
