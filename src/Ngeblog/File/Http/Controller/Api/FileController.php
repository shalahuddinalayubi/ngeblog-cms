<?php

namespace Ngeblog\File\Http\Controller\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use Ngeblog\File\Models\File;
use Ngeblog\File\Transformers\FileTransformer;

class FileController extends Controller
{
    public function index()
    {
        $paginate = File::paginate();
        
        $files = $paginate->getCollection();

        return fractal()
                ->collection($files, new FileTransformer, 'files')
                ->serializeWith(new JsonApiSerializer)
                ->paginateWith(new IlluminatePaginatorAdapter($paginate))
                ->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {          
            return response()->json($this->createJsonApiError($validator), 422);
        }


        if ($request->file('file')) {
            $path = $request->file('file')->store('images', 'public');

            $file = File::create(['path' => $path]);

            return fractal()->item($file, new FileTransformer, 'files')->serializeWith(new JsonApiSerializer)->respond();
        }
    }

    private function createJsonApiError($validator)
    {
        $keys = $validator->errors()->keys();

        $errors = [];

        foreach($keys as $key) {
            $error = [
                'title' => 'Validation error',
                'detail' => $validator->errors()->get($key)[0],
                'source' => [
                    'pointer' => $key,
                ],
            ];

            array_push($errors, $error);
        }

        return [
            'errors' => $errors,
        ];
    }
}
