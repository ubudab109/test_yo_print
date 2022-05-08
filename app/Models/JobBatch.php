<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Date;

class JobBatch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_batches';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be appends.
     * @var array
     */
    protected $appends = [
        'progress', 'total_progress', 'time', 'created_date'
    ];

    /**
     * Get the total number of jobs that have been processed by the batch thus far.
     *
     * @return int
     */
    public function processedJobs()
    {
        return $this->total_jobs - $this->pending_jobs;
    }

    public function getCreatedDateAttribute() {
        return Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
    }

    public function getTimeAttribute()
    {

        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Date::now());
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->getCreatedDateAttribute());


        $diff_in_minutes = $to->diffInMinutes($from);

        return [
            
            'created' => date("Y-m-d h:i A", $this->created_at),
            'minutes' => $diff_in_minutes. ' minutes ago'
        ];
        
    }

    public function getTotalProgressAttribute()
    {
        $test = Bus::findBatch($this->id);
        return $test->progress();
    }

    /**
     * Get the status of jobs that have been executed.
     *
     * @return int
     */
    public function getProgressAttribute()
    {
        $total = $this->getTotalProgressAttribute();

        if ($total >= 100) $status = 'completed';

        if ($total == 0 && is_null($this->finished_at)) $status = 'pending';

        if ($total >= 1 && $total < 100) $status = 'processing';

        if ($this->failed_jobs > 0) $status = 'failed';

        return $status;
    }
}
