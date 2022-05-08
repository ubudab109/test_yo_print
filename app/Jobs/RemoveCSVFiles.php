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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class RemoveCSVFiles implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $unlinkpath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($unlinkpath)
    {
        $this->unlinkpath   = $unlinkpath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // delete file when jobs is complete
        unlink(public_path('storage/tmp-files/'.$this->unlinkpath));
    }
}
