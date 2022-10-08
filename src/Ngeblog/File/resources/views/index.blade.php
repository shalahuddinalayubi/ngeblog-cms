@extends('template::app')

@section('body')
    @include('template::navbar')

    <div class="container mx-auto pb-5 px-2 md:px-0">
        <the-upload-file post-action="{{ route('api.files.store') }}"></the-upload-file>

        @if (Session::has('status'))
            <div class="flex items-center bg-red-500 text-white text-sm font-bold px-4 py-3 mt-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>{{ Session::get('status') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-2">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Image
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($files as $file)    
                        <tr class="bg-white border-b">
                            <td class="py-4 px-6">
                                <img class="object-scale-down max-h-10" src="{{ Storage::url($file->path); }}">
                            </td>
                            <td class="py-4 px-6">
                                <form action="{{ route('files.destroy', ['id' => $file->id]) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="underline text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center">
        {{ $files->links('template::pagination') }}
    </div>
@endsection
