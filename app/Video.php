<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
