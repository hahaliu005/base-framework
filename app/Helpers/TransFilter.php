<?php

namespace App\Helpers;

use FFMpeg\Filters\Video\VideoFilterInterface;
use FFMpeg\Media\Video;
use FFMpeg\Format\VideoInterface;

class TransFilter implements VideoFilterInterface
{
    protected $params;
    protected $priority;
    public function __construct(array $params, $priority = 0)
    {
        $this->params = $params;
        $this->priority = $priority;
    }

    public function getPriority()
    {
        return $this->priority;
        // TODO: Implement getPriority() method.
    }

    public function apply(Video $video, VideoInterface $format)
    {
        return $this->params;
    }
}
