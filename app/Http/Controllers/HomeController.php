<?php

namespace App\Http\Controllers;

use App\Jobs\RemoveCSVFiles;
use App\Jobs\UploadCsv;
use App\Models\JobBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        return view('welcome', ['batchs' => $this->allBatch()]);
    }

    public function allBatch()
    {
        return JobBatch::orderBy('created_at', 'DESC')->get()->toArray();
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
        $savedFile = uploadFile($uploadedFile);
        $path = asset('storage/tmp-files/'. $savedFile);

        Bus::batch([
            new UploadCsv($path, $savedFile),
            new RemoveCSVFiles($savedFile),
        ])
        ->name($savedFile)
        ->allowFailures(false)
        ->onConnection('redis')
        ->onQueue('csv_upload')
        ->dispatch();

        return response()->json([
            'status'    => 200,
        ]);
        
    }
}
