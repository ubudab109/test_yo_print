<?php

namespace App\Http\Controllers;

use App\Jobs\UploadCsv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        return view('welcome');
    }


    public function uploadCsv(Request $request)
    {
        $request->validate([
            'file'  => 'required|mimes:csv',
        ],[
            'file.required' => 'Please Upload CSV',
            'file.mimes'    => 'Please Upload CSV only with CSV Format'
        ]);

        $uploadedFile = $request->file('file');

        Storage::disk('local')->put(
            'files/',
            $uploadedFile,
        );

        return redirect()->back();
        
    }
}
