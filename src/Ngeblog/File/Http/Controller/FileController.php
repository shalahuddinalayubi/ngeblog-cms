<?php

namespace Ngeblog\File\Http\Controller;

use App\Http\Controllers\Controller;
use Ngeblog\File\Models\File;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::paginate();

        return view('file::index', compact('files'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::findOrFail($id);

        return $file->delete()
            ? redirect()->back()->with('status', 'Delete success')
            : redirect()->back()->with('status', 'Delete failed');
    }
}
