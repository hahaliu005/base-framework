<?php

namespace App\Helpers;

use FFMpeg\Filters\Video\VideoFilterInterface;
use FFMpeg\Media\Video;
use FFMpeg\Format\VideoInterface;

class DrawTextFilter implements VideoFilterInterface
{
    private $text;
    private $priority;
    private $attributes;

    const DEFAULT_FONT_SIZE = 50;
    const DEFAULT_SPEED = 80;
    public function __construct($text, $attributes=[], $priority = 0)
    {
        $this->text = $text;
        $this->priority = $priority;
        $this->attributes = $attributes;
    }

    public function getPriority()
    {
        return $this->priority;
        // TODO: Implement getPriority() method.
    }

    public function apply(Video $video, VideoInterface $format)
    {
        $fontSize = (! empty($this->attributes['fontsize'])) ? $this->attributes['fontsize'] : self::DEFAULT_FONT_SIZE;
        $speed = (! empty($this->attributes['speed'])) ? $this->attributes['speed'] : self::DEFAULT_SPEED;
        $fontFile = base_path() . '/Lantinghei.ttc';

        return array(
            '-vf',
            sprintf(
                "drawtext='fontfile=%s: text=%s: x=W-(t-10)*%s: y=H-text_h: fontsize=%s: alpha=0.5: fontcolor=white@0.9'",
                $fontFile,
                $this->text,
                $speed,
                $fontSize
            ),
        );
    }
}