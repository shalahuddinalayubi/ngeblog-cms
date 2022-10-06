<?php

namespace Ngeblog\File\Transformers;

use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;
use Ngeblog\File\Models\File;

class FileTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(File $file)
    {
        return [
            'id' => $file->id,
            'path' => $file->path,
            'url' => asset('storage/' . $file->path),
        ];
    }
}
