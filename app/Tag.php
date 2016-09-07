<?php

namespace App;

class Tag extends AppModel
{
    public function videos()
    {
        return $this->belongsToMany(Video::class, 'tag_id', 'video_id');
    }
}
