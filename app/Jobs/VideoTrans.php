<?php

namespace App\Jobs;

use App\Helpers\VideoTrans as VideoTransHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VideoTrans implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $videoId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($videoId)
    {
        $this->videoId = $videoId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        VideoTransHelper::videoTrans($this->videoId);
    }
}
