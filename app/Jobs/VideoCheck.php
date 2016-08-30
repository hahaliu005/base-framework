<?php

namespace App\Jobs;

use App\Helpers\VideoTrans;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VideoCheck implements ShouldQueue
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
        \Log::info('start check video, video_id: ' . $this->videoId);

        VideoTrans::videoCheck($this->videoId);
    }
}
