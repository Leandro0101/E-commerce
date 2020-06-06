<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutoFoto extends Model
{
    protected $fillable = ['path'];
    
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
