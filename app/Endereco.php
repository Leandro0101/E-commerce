<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = ["id","cliente","estado","cidade","bairro","endereco","numero"];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
