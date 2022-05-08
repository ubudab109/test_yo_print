<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class UploadCsv implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath, $unlinkpath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath, $unlinkpath)
    {
        $this->filePath     = $filePath;
        $this->unlinkpath   = $unlinkpath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Redis::throttle('upload-csv')->allow(2)->every(1)->then( function () {

            dump('processing :'. $this->unlinkpath);
            $file = fopen($this->filePath, 'r');
            $header = fgetcsv($file);
    
            $escapedHeader = [];
    
    
            foreach ($header as $key => $value) {
                $lowerHeader = strtolower($value);
                $escapedItem = preg_replace('/[^a-z,_]/', '', $lowerHeader);
                array_push($escapedHeader, $escapedItem);
            }
    
            while ($columns = fgetcsv($file)) {
                if ($columns[0] == "") {
                    continue;
                }
    
                // trim data
                foreach ($columns as $key => &$value) {
                    // cleanup utf-8
                    $value = iconv("utf-8", "utf-8//ignore", $value);
                }
    
                $data = array_combine($escapedHeader, $columns);
    
                // setting type
                foreach ($data as $key => &$value) {
                    $value = ($key == "piece_price") ? (float)$value : $value;
                }
    
                // table update or create
                Product::updateOrCreate([
                    'unique_key'    => $data['unique_key'],
                ], [
                    'product_title'             => $data['product_title'],
                    'product_description'       => $data['product_description'],
                    'style#'                    => $data['style'],
                    'sanmar_mainframe_color'    => $data['sanmar_mainframe_color'],
                    'size'                      => $data['size'],
                    'color_name'                => $data['color_name'],
                    'piece_price'               => $data['piece_price'],
                ]);
            }
        }, function () {
            $this->release(10);
        });
        
    }
}
