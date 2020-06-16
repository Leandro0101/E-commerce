<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Favorito extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

}


