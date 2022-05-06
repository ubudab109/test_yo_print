<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadCsv implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file     = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = $this->file->getRealPath();
        $records = array_map('str_getcsv', file($path));
        $row = [];
        if(!count($records) > 0) {
            return 'error';
        }

        $fields = array_map('strtolower', $records[0]);

        array_shift($records);

        foreach ($records as $record) {
            if (count($fields) != count($record)) {
                return 'csv_upload_invalid_data';
            }

            $record = array_map('html_entity_decode', $record);

            $record = array_combine($fields, $record);

            $row[] = $this->clear_encoding($record);
        }

        
        foreach ($row as $data) {
            Product::updateOrCreate([
                'unique_key'                => $data['UNIQUE_KEY']
            ], [
                'product_title'             => $data['PRODUCT_TITLE'],
                'product_description'       => $data['PRODUCT_DESCRIPTION'],
                'style#'                    => $data['STYLE#'],
                'sanmar_mainframe_color'    => $data['SANMAR_MAINFRAME_COLOR'],
                'size'                      => $data['SIZE'],
                'color_name'                => $data['COLOR_NAME'],
                'piece_price'               => $data['PIECE_PRICE'],
            ]);
        }
    }

    private function clear_encoding($value) 
    {
        if (is_array($value)) {
            $clean = [];
            foreach ($value as $key => $val) {
                $clean[$key] = mb_convert_encoding($val, 'UTF-8', 'UTF-8');
            }
            return $clean;
        }

        return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }
}
